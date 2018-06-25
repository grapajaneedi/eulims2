<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\Functions;
use common\models\lab\Cancelledrequest;


$sweetalert = new Functions();

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */

$this->title = empty($model->request_ref_num) ? $model->request_id : $model->request_ref_num;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$rstlID=$GLOBALS['rstl_id'];
$Year=date('Y', strtotime($model->request_datetime));
// /lab/request/saverequestransaction
$js=<<<SCRIPT
    $("#btnSaveRequest").click(function(){
        var SampleRows=$sampleDataProvider->count;
        var AnalysisRows=$analysisdataprovider->count;
        var msg='';
        if(SampleRows>0 && AnalysisRows>0){
            $.post(this.value, {
                request_id: $model->request_id,
                lab_id: $model->lab_id,
                rstl_id: $rstlID,
                year: $Year
            }, function(result){
               if(result){
                   location.reload();
               }
            });
        }else{
            if(SampleRows<=0 && AnalysisRows<=0){
               msg='Please Add Sample and Analysis!';
            }else if(SampleRows<=0 && AnalysisRows>0){
               msg='Please Add Sample!';
            }else if(SampleRows>0 && AnalysisRows<=0){
               msg='Please Add Analysis!';
            }
            krajeeDialog.alert(msg);
        }
    });  
       
SCRIPT;
$this->registerJs($js);
if($model->request_ref_num==null || $model->status_id==2){
    $CancelButton='';
}else{
    $Func="LoadModal('Cancel Request','/lab/cancelrequest/create?req=".$model->request_id."',true,500)";
    $CancelButton='<button id="btnCancel" onclick="'.$Func.'" type="button" style="float: right" class="btn btn-danger"><i class="fa fa-remove"></i> Cancel Request</button>';
}
if($model->status_id==2){
    // Cancelled Request
    $CancelClass='request-cancelled';
    $BackClass='background-cancel';
}else{
    $CancelClass='cancelled-hide';
    $BackClass='';
}
$Request_Ref=$model->request_ref_num;
$Cancelledrequest= Cancelledrequest::find()->where(['request_id'=>$model->request_id])->one();
if($Cancelledrequest){
    $Reasons=$Cancelledrequest->reason;
    $DateCancelled=date('m/d/Y h:i A', strtotime($Cancelledrequest->cancel_date));
    $CancelledBy=$sweetalert->GetProfileName($Cancelledrequest->cancelledby);
}else{
    $Reasons='&nbsp;';
    $DateCancelled='';
    $CancelledBy='';
}
if($Request_Ref){
    $enableRequest=true;
    $disableButton="disabled";
    $ClickButton='';
    $btnID="";
}else{ // NO reference number yet
    $enableRequest=false;
    $ClickButton='addSample(this.value,this.title)';
    $disableButton="";
    $btnID="id='btnSaveRequest'";
}

?>
<div class="section-request"> 
<div id="cancelled-div" class="outer-div <?= $CancelClass ?>">
        <div class="inner-div">
        <img src="/images/cancelled.png" alt="" style="width: 300px;margin-left: 80px"/>
        <div class="panel panel-primary">
            <div class="panel-heading"></div>
            <table class="table table-condensed table-hover table-striped table-responsive">
                 <tr>
                    <th style="background-color: lightgray">Date Cancelled</th>
                    <td><?= $DateCancelled ?></td>
                </tr>
                 <tr>
                    <th style="background-color: lightgray">Request Reference #</th>
                    <td><?= $Request_Ref ?></td>
                </tr>
                <tr>
                    <th style="width: 120px;background-color: lightgray">Reason of Cancellation</th>
                    <td style="width: 230px"><?= $Reasons ?></td>
                </tr>
                <tr>
                    <th style="background-color: lightgray">Cancelled By</th>
                    <td><?= $CancelledBy ?></td>
                </tr>
            </table>
        </div>
        </div>
</div> 
<div class="<?= $BackClass ?>"></div>
<div class="request-view ">
    <div class="container table-responsive">
        <?php
            echo DetailView::widget([
            'model'=>$model,
            'responsive'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
                'heading'=>'<i class="glyphicon glyphicon-book"></i> Request # ' . $model->request_ref_num,
                'type'=>DetailView::TYPE_PRIMARY,
            ],
            'buttons1' => '',
            'attributes'=>[
                [
                    'group'=>true,
                    'label'=>'Request Details '.$CancelButton,
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'request_ref_num', 
                            'label'=>'Request Reference Number',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Customer / Agency',
                            'format'=>'raw',
                            'value'=>$model->customer->customer_name,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Request Date',
                            'format'=>'raw',
                            'value'=>Yii::$app->formatter->asDate($model->request_datetime, 'php:F j, Y'),
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Address',
                            'format'=>'raw',
                            'value'=>$model->customer->address,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                    
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Request Time',
                            'format'=>'raw',
                            'value'=>Yii::$app->formatter->asDate($model->request_datetime, 'php:h:i a'),
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Tel no.',
                            'format'=>'raw',
                            'value'=>$model->customer->tel,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'report_due',
                            'label'=>'Report Due Date',
                            'format'=>'raw',
                            'value'=>Yii::$app->formatter->asDate($model->request_datetime, 'php:F j, Y'),
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Fax no.',
                            'format'=>'raw',
                            'value'=>$model->customer->fax,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'group'=>true,
                    'label'=>'Payment Details',
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [
                            'label'=>'OR No.',
                            'value'=>'',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Collection',
                            'format'=>'raw',
                            'value'=>'0',
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'OR Date',
                            'value'=>'',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Unpaid Balance',
                            'format'=>'raw',
                            'value'=>'0',
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                
                [
                    'group'=>true,
                    'label'=>'Transaction Details',
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'receivedBy', 
                            'format'=>'raw',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'conforme',
                            'format'=>'raw',
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
            ],

        ]);
        ?>
    </div>
    <div class="container">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                [
                    'attribute'=>'sample_code',
                    'enableSorting' => false,
                    'contentOptions' => [
                        'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'attribute'=>'samplename',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'description',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($data){
                        return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".$data->sampling_date."</b></span>,&nbsp;".$data->description : $data->description;
                    },
                   'contentOptions' => [
                        'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{update} {delete} {cancel}',
                    'dropdown' => false,
                    'dropdownOptions' => ['class' => 'pull-right'],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete') {
                            $url ='/lab/sample/delete?id='.$model->sample_id;
                            return $url;
                        } 
                        if ($action === 'cancel') {
                            $url ='/lab/sample/cancel?id='.$model->sample_id;
                            return $url;
                        }
                    },
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'buttons' => [
                        // 'view' => function ($url, $model) {
                        //     return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                        //                 'title' => Yii::t('app', 'lead-view'),
                        //     ]);
                        // },
                        'update' => function ($url, $model) {
                            if($model->active == 1){
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '', ['class'=>'btn btn-primary','title'=>'Update Sample','onclick' => 'updateSample('.$model->sample_id.')']);
                            } else {
                                //return '<span class="glyphicon glyphicon-ban-circle"></span> Cancelled.';
                                return null;
                            }
                        },
                        'delete' => function ($url, $model) {
                            //return $model->sample_code != "" ? '' : Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,['class'=>'btn btn-primary','title'=>'Update Sample',]);
                            if($model->sample_code == "" && $model->active == 1){
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,['data-confirm'=>"Are you sure you want to delete <b>".$model->samplename."</b>?",'data-method'=>'post','class'=>'btn btn-primary','title'=>'Delete Sample','data-pjax'=>'0']);
                            } else {
                                return null;
                            }
                        },
                        'cancel' => function ($url, $model){
                            //return $model->sample_code == "" ? '' : Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', $url, ['data-confirm'=>"Are you sure you want to cancel ".$model->sample_code."?",'class'=>'btn btn-primary','title'=>'Cancel Sample','data-pjax'=>'0']);
                            if($model->sample_code != "" && $model->active == 1){
                                return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', $url, ['data-confirm'=>"Are you sure you want to cancel <b>".$model->sample_code."</b>?\nAll analyses that this sample contains will also be cancelled.",'data-method'=>'post','class'=>'btn btn-primary','title'=>'Cancel Sample','data-pjax'=>'0']);
                            } else {
                                //return '<span class="glyphicon glyphicon-ban-circle"></span> Cancelled.';
                                return $model->active == 0 ? '<span class="text-danger" style="font-size:12px;"><span class="glyphicon glyphicon-ban-circle"></span> Cancelled.</span>' : '';
                                //return null;
                            }
                        },
                    ],
                ],
            ];

            echo GridView::widget([
                'id' => 'sample-grid',
                'dataProvider'=> $sampleDataProvider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Samples</h3>',
                    'type'=>'primary',
                    'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['disabled'=>$enableRequest, 'value' => Url::to(['sample/create','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn'])." ".Html::button('<i class="glyphicon glyphicon-print"></i> Print Label', ['disabled'=>$enableRequest, 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['lab/request/printlabel','request_id'=>$model->request_id]) . "';" ,'title'=>'Print Label',  'class' => 'btn btn-success']),
                    'after'=>false,
                ],
                // 'rowOptions' => function ($model, $key, $index, $grid) {
                //     return [
                //         'id' => $model->sample_id,
                //         'onclick' => 'updateSample('.$model->sample_id.');',
                //         'style' => 'cursor:pointer;',
                //         'title' => 'Click to update sample',
                //     ];
                // },
                'columns' => $gridColumns,
                'toolbar' => [
                    'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i>', [Url::to(['request/view','id'=>$model->request_id])], [
                                'class' => 'btn btn-default', 
                                'title' => 'Reset Grid'
                            ]),
                    '{toggleData}',
                ],
            ]);
        ?>
        </div>
    </div>
    <div class="container">
        <?php
            $analysisgridColumns = [
                [
                    'attribute'=>'sample_name',
                    'header'=>'Sample',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        return $model->sample->samplename;
                    },
                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                   
                ],
                [
                    'attribute'=>'sample_code',
                    'header'=>'Sample Code',
                    'value' => function($model) {
                        return $model->sample->sample_code;
                    },
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'testname',
                    'header'=>'Test/ Calibration Requested',
                    // 'value' => function($model) {
                    //     return $model->samples->sample_code;
                    // },
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'method',
                    'header'=>'Test Method',
                    // 'value' => function($model) {
                    //     return $model->samples->sample_code;
                    // },
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'quantity',
                    'header'=>'Quantity',
                    // 'value' => function($model) {
                    //     return $model->samples->sample_code;
                    // },
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'fee',
                    'header'=>'Unit Price',
                    // 'value' => function($model) {
                    //     return $model->samples->sample_code;
                    // },
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'status',
                    'header'=>'Status',
                    // 'value' => function($model) {
                    //     return $model->samples->sample_code;
                    // },
                    'enableSorting' => false,
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{update} {delete} {cancel}',
                    'dropdown' => false,
                    'dropdownOptions' => ['class' => 'pull-right'],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        // if ($action === 'delete') {
                        //     $url ='/lab/sample/delete?id='.$model->sample_id;
                        //     return $url;
                        // } 
                        // if ($action === 'cancel') {
                        //     $url ='/lab/sample/cancel?id='.$model->sample_id;
                        //     return $url;
                        // }
                    },
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'buttons' => [
                        'update' => function ($url, $model) {
                            // if($model->active == 1){
                            //     return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '', ['class'=>'btn btn-primary','title'=>'Update Sample','onclick' => 'updateSample('.$model->sample_id.')']);
                            // } else {
                            //     return null;
                            // }
                        },
                        'delete' => function ($url, $model) {
                            // if($model->sample_code == "" && $model->active == 1){
                            //     return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,['data-confirm'=>"Are you sure you want to delete <b>".$model->samplename."</b>?",'data-method'=>'post','class'=>'btn btn-primary','title'=>'Delete Sample','data-pjax'=>'0']);
                            // } else {
                            //     return null;
                            // }
                        },
                        'cancel' => function ($url, $model){
                            // if($model->sample_code != "" && $model->active == 1){
                            //     return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', $url, ['data-confirm'=>"Are you sure you want to cancel <b>".$model->sample_code."</b>?\nAll analyses that this sample contains will also be cancelled.",'data-method'=>'post','class'=>'btn btn-primary','title'=>'Cancel Sample','data-pjax'=>'0']);
                            // } else {
                            //     return $model->active == 0 ? '<span class="text-danger" style="font-size:12px;"><span class="glyphicon glyphicon-ban-circle"></span> Cancelled.</span>' : '';
                            // }
                        },
                    ],
                ],
               
            ];
            echo GridView::widget([
                'id' => 'analysis-grid',
                'dataProvider'=> $analysisdataprovider,
                'summary' => '',
                'responsive'=>true, 
                'hover'=>true,
                //'filterModel' => $searchModel, JANEEDI 
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Analysis</h3>',
                    'type'=>'primary',
                    //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add Analysis', ['/lab/analysis/create'], ['class' => 'btn btn-success'],['id' => 'modalBtn']),
                    'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Analysis', ['disabled'=>$enableRequest,'value' => Url::to(['analysis/create','id'=>$model->request_id]),'title'=>'Add Analyses', 'onclick'=>$ClickButton, 'class' => 'btn btn-success','id' => 'modalBtn'])."   ".
                    Html::button('<i class="glyphicon glyphicon-plus"></i> Add Package', ['disabled'=>$enableRequest,'value' => Url::to(['/services/packagelist/createpackage','id'=>$model->request_id]),'title'=>'Add Package', 'onclick'=>$ClickButton, 'class' => 'btn btn-success','id' => 'modalBtn'])." ".
                    Html::button('<i class="glyphicon glyphicon-plus"></i> Additional Fees', ['disabled'=>$enableRequest,'value' => Url::to(['/lab/fee/create','id'=>$model->request_id]),'title'=>'Add Additional Fees', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
                   'after'=>false,
                  //  'after'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Analysis', ['value' => Url::to(['sample/create','request_id'=>1]),'title'=>'Add Analysis', 'class' => 'btn btn-success','id' => 'modalBtn']),
                   'footer'=>"<div class='row' style='margin-left: 2px;padding-top: 5px'><button ".$disableButton." value='/lab/request/saverequestransaction' ".$btnID." class='btn btn-success'><i class='fa fa-save'></i> Save Request</button></div>",
                ],
                'columns' => $analysisgridColumns,
                'toolbar' => [
                ],
            ]);
        ?>
    </div>
</div>
</div>
<script type="text/javascript">
    $('#sample-grid tbody td').css('cursor', 'pointer');
    function updateSample(id){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       var url = '/lab/sample/update?id='+id;
        $('.modal-title').html('Update Sample');
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    // function deleteSample(id){
    //    //var url = 'Url::to(['sample/update']) . "?id=' + id;
    //    var url = '/lab/sample/update?id='+id;
    //     $('.modal-title').html('Update Sample');
    //     $('#modal').modal('show')
    //         .find('#modalContent')
    //         .load(url);
    // }
    // function cancelSample(id){
    //    //var url = 'Url::to(['sample/update']) . "?id=' + id;
    //    var url = '/lab/sample/update?id='+id;
    //     $('.modal-title').html('Update Sample');
    //     $('#modal').modal('show')
    //         .find('#modalContent')
    //         .load(url);
    // }
    function addSample(url,title){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       //var url = '/lab/sample/update?id='+id;
        $(".modal-title").html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
</script>

<?php
$this->registerJs("
   /* function loadMessage(url,id){
        $.ajax({
            url: url,
            dataType: 'json',
            method: 'GET',
            data: form.serialize(),
            success: function (data, textStatus, jqXHR) {
                //$('#sample-samplename').val(data.name);
                //$('#sample-description').val(data.description);
                $('.image-loader').removeClass( \"img-loader\" );
                $('.modal-title').html('Sample');
                var content = $('#modalContent').html(data.)
                $('#modal').modal('show')
                        .find(content)
                        .load(url);
            },
            beforeSend: function (xhr) {
                //alert('Please wait...');
                $('.image-loader').addClass( \"img-loader\" );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('An error occured!');
                alert('Error in ajax request');
            }
        });

    }*/
");
?>

<?php
    // This section will allow to popup a notification
    $session = Yii::$app->session;
    if ($session->isActive) {
        $session->open();
        if (isset($session['deletemessage'])) {
            $sweetalert->CrudAlert("Successfully Deleted","WARNING",true);
            unset($session['deletemessage']);
            $session->close();
        }
        if (isset($session['updatemessage'])) {
            $sweetalert->CrudAlert("Successfully Updated","SUCCESS",true);
            unset($session['updatemessage']);
            $session->close();
        }
        if (isset($session['savemessage'])) {
            $sweetalert->CrudAlert("Successfully Saved","SUCCESS",true);
            unset($session['savemessage']);
            $session->close();
        }
        if (isset($session['cancelmessage'])) {
            $sweetalert->CrudAlert("Successfully Cancelled","WARNING",true);
            unset($session['cancelmessage']);
            $session->close();
        }
        if (isset($session['requestmessage'])) {
            $sweetalert->CrudAlert("Successfully Generated Reference Number and Sample Code","WARNING",true);
            unset($session['requestmessage']);
            $session->close();
        }
    }
?>