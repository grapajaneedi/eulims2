<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\Functions;
use common\components\ReferralComponent;
use common\models\lab\Cancelledrequest;
use common\models\lab\Discount;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Sampletype;
use common\models\finance\Paymentitem;

use common\models\lab\Package;
use yii\bootstrap\Modal;
use kartik\dialog\Dialog;
use yii\web\JsExpression;

$Connection = Yii::$app->financedb;
$func = new Functions();
$referralcomp = new ReferralComponent();

$this->title = empty($model->request_ref_num) ? $model->request_id : $model->request_ref_num;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$rstlID=Yii::$app->user->identity->profile->rstl_id;//$GLOBALS['rstl_id'];
$Year=date('Y', strtotime($model->request_datetime));
$paymentitem= Paymentitem::find()->where(['request_id'=> $model->request_id])->one();

if ($paymentitem){
    $analysistemplate = "{view}";
}else{
    $analysistemplate = "{view} {update} {delete}";
}
// /lab/request/saverequestransaction
$js=<<<SCRIPT
    $("#btnSaveRequest").click(function(){
        var SampleRows=$sampleDataProvider->count;
        var AnalysisRows=$analysisdataprovider->count;
        var msg='';
        if(SampleRows>0 && AnalysisRows>0){
            $.post('/lab/request/saverequestransaction', {
                request_id: $model->request_id,
                lab_id: $model->lab_id,
                rstl_id: $rstlID,
                year: $Year
            }, function(result){
               if(result){
                    //document.write(result);
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
if($model->request_ref_num==null || $model->status_id==0){
    $CancelButton='';
}else{
    $Func="LoadModal('Cancellation of Request','/lab/cancelrequest/create?req=".$model->request_id."',true,500)";
    $CancelButton='<button id="btnCancel" onclick="'.$Func.'" type="button" style="float: right" class="btn btn-danger"><i class="fa fa-remove"></i> Cancel Request</button>';
}
if($model->status_id==0){
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
    $CancelledBy=$func->GetProfileName($Cancelledrequest->cancelledby);
}else{
    $Reasons='&nbsp;';
    $DateCancelled='';
    $CancelledBy='';
}
if($Request_Ref){//With Reference
    $enableRequest=true;
    $disableButton="disabled";///reports/preview?url=/lab/request/print-request?id=10
    $EnablePrint="<a href='/reports/preview?url=/lab/request/print-request?id=".$model->request_id."' class='btn btn-primary' style='margin-left: 5px'><i class='fa fa-print'></i> Print Request</a>";
    $ClickButton='';
    $ClickButtonAnalysisReferral='';
    $btnID="";
}else{ // NO reference number yet
    $enableRequest=false;
    $ClickButton='addSample(this.value,this.title)';
    $ClickButtonAnalysisReferral='addAnalysisReferral(this.value,this.title)';
    $disableButton="";
    $EnablePrint="<span class='btn btn-primary' disabled style='margin-left: 5px'><i class='fa fa-print'></i> Print Request</span>";
    $btnID="id='btnSaveRequest'";
}
$Params=[
    'mRequestID'=>$model->request_id
];
$row=$func->ExecuteStoredProcedureOne("spGetPaymentDetails(:mRequestID)", $Params, $Connection);
$payment_total=number_format($row['TotalAmount'],2);
$orNumbers=$row['ORNumber'];
$orDate=$row['ORDate'];
$UnpaidBalance1=$model->total-$row['TotalAmount'];
$UnpaidBalance=number_format($UnpaidBalance1,2);
$PrintEvent=<<<SCRIPT
  $("#btnPrintRequest").click(function(){
      alert("Printing...");
  });   
SCRIPT;
$this->registerJs($PrintEvent);
$requeststatus = $model->status_id; //get status value of referral request
$notified = !empty($modelref_request->notified) ? $modelref_request->notified : 0; //get value if notified
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
    <div class="image-loader" style="display: hidden;"></div>
    <!--<div id="notification_details" style="display: hidden;">
        <input type="text" name="sender_remarks" />
    </div>-->
    <div class="container table-responsive">
        <?php

        if($model->request_type_id == 2){
            //for referral request
            echo DetailView::widget([
            'model'=>$model,
            'responsive'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
                'heading'=>'<i class="glyphicon glyphicon-book"></i> Referral Code ' . $model->request_ref_num,
                'type'=>DetailView::TYPE_PRIMARY,
            ],
            'buttons1' => '',
            'attributes'=>[
                [
                    'group'=>true,
                    'label'=>'Referral Details '.$CancelButton,
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'request_ref_num', 
                            'label'=>'Referral Code',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Customer / Agency',
                            'format'=>'raw',
                            'value'=> $model->customer ? $model->customer->customer_name : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Referral Date / Time',
                            'format'=>'raw',
                            'value'=> ($model->request_datetime != "0000-00-00 00:00:00") ? Yii::$app->formatter->asDate($model->request_datetime, 'php:F j, Y h:i a') : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Address',
                            'format'=>'raw',
                            'value'=>$model->customer ? $model->customer->address : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                    
                ],
                [
                    'columns' => [
                       [
                            'attribute'=>'report_due',
                            'label'=>'Sample Received Date',
                            'format'=>'raw',
                            'value'=> !empty($model->referralrequest->sample_received_date) ? Yii::$app->formatter->asDate($model->referralrequest->sample_received_date, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No sample received date</i>",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Tel no.',
                            'format'=>'raw',
                            'value'=>$model->customer ? $model->customer->tel : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'report_due',
                            'label'=>'Estimated Due Date',
                            'format'=>'raw',
                            'value'=> ($model->report_due != "0000-00-00 00:00:00") ? Yii::$app->formatter->asDate($model->report_due, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Fax no.',
                            'format'=>'raw',
                            'value'=>$model->customer ? $model->customer->fax : "",
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
                            'value'=>$orNumbers,
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Collection',
                            'format'=>'raw',
                            'value'=>"₱".$payment_total,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'OR Date',
                            'value'=>$orDate,
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Unpaid Balance',
                            'format'=>'raw',
                            'value'=>"₱".$UnpaidBalance,
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
        } else {
            //not referral request
            echo "<div class='alert alert-danger'>
                <strong>Not a referral request.</strong>.
            </div>";
        }
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
                        return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".date("Y-m-d h:i A",strtotime($data->sampling_date))."</b></span>,&nbsp;".$data->description : $data->description;
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
                        'update' => function ($url, $model) use ($requeststatus,$notified) {
                            if($model->active == 1 && $requeststatus > 0 && $notified == 0){
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', ['class'=>'btn btn-primary','title'=>'Update Sample','onclick' => 'updateSample('.$model->sample_id.')']);
                            } else {
                                return null;
                            }
                        },
                        'delete' => function ($url, $model) use ($requeststatus,$notified) {
                            if($model->sample_code == "" && $model->active == 1 && $requeststatus > 0 && $notified == 0){
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,['data-confirm'=>"Are you sure you want to delete <b>".$model->samplename."</b>?",'data-method'=>'post','class'=>'btn btn-danger','title'=>'Delete Sample','data-pjax'=>'0']);
                            } else {
                                return null;
                            }
                        },
                        'cancel' => function ($url, $model) use ($requeststatus,$notified) {
                            if($model->sample_code != "" && $model->active == 1 && $requeststatus > 0 && $notified == 0) {
                                return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', '#', ['class'=>'btn btn-warning','title'=>'Cancel Sample','onclick' => 'cancelSample('.$model->sample_id.')']);
                            } else {
                                return $model->active == 0 ? Html::a('<span style="font-size:12px;"><span class="glyphicon glyphicon-ban-circle"></span> Cancelled.</span>','#',['class'=>'btn btn-danger','title'=>'View Cancel Remarks','onclick' => 'viewRemarkSample('.$model->sample_id.')']) : '';
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
                    'before'=>($requeststatus > 0 && $notified == 0) ? Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['disabled'=>$enableRequest, 'value' => Url::to(['sample/create','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn'])." ".Html::button('<i class="glyphicon glyphicon-print"></i> Print Label', ['disabled'=>!$enableRequest, 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/reports/preview?url=/lab/request/printlabel','request_id'=>$model->request_id]) . "';" ,'title'=>'Print Label',  'class' => 'btn btn-success']) : null,
                    'after'=>false,
                ],
                /*'krajeeDialogSettings' => [ 
                    'options' => ['title' => 'Your sssse'],
                    'overrideYiiConfirm' => false,
                ],*/
                'columns' => $gridColumns,
                'toolbar' => [
                    'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Refresh Grid', [Url::to(['request/view','id'=>$model->request_id])], [
                                'class' => 'btn btn-default', 
                                'title' => 'Refresh Grid'
                            ]),
                    //'{toggleData}',
                ],
            ]);
        ?>
        </div>
    </div>
    <div class="container">
    <?php

        $samplecount = $sampleDataProvider->getTotalCount();
        if ($samplecount==0){
            $enableRequest = true;
        }else{
            $enableRequest = false;
        }

        $analysisgridColumns = [
            [
                'attribute'=>'sample_name',
                'header'=>'Sample',
              
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function($model) {
                    return $model->sample ? $model->sample->samplename : '-';
                },
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
               
            ],
            [
                'attribute'=>'sample_code',
                'header'=>'Sample Code',
                'value' => function($model) {
                    return $model->sample ? $model->sample->sample_code : '-';
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
            ],
            [
                'attribute'=>'testname',
                'header'=>'Test/ Calibration Requested',
                'contentOptions' => ['style' => 'width: 15%;word-wrap: break-word;white-space:pre-line;'],
                'enableSorting' => false,
            ],
            [
                'attribute'=>'method',
                'header'=>'Test Method',
                'enableSorting' => false,  
                'contentOptions' => ['style' => 'width: 50%;word-wrap: break-word;white-space:pre-line;'],              
            ],
            [
                'attribute'=>'quantity',
                'header'=>'Quantity',
                'hAlign'=>'center',
                'enableSorting' => false,
                'pageSummary' => '<span style="float:right";>SUBTOTAL<BR>DISCOUNT<BR><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL</B></span>',       
            ],
            [
                'attribute'=>'fee',
                'header'=>'Unit Price',
                'enableSorting' => false,
                'hAlign'=>'right',
                'value'=>function($model){
                    return number_format($model->fee,2);
                },
                'contentOptions' => [
                    'style'=>'max-width:80px; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
                'hAlign' => 'right', 
                'vAlign' => 'left',
                'width' => '7%',
                'format' => 'raw',
                'pageSummary'=> function () use ($subtotal,$discounted,$total,$countSample) {
                    if($countSample > 0){
                        return  '<div id="subtotal">₱'.number_format($subtotal, 2).'</div><div id="discount">₱'.number_format($discounted, 2).'</div><div id="total"><b>₱'.number_format($total, 2).'</b></div>';
                    } else {
                        return '';
                    }
                },
            ],
            [
                'header'=>'Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
              
                  if ($model->tagging){

                   if ($model->tagging->tagging_status_id==1) {
                          return "<span class='badge btn-primary' style='width:90px;height:20px'>ONGOING</span>";
                      }else if ($model->tagging->tagging_status_id==2) {
                          return "<span class='badge btn-success' style='width:90px;height:20px'>COMPLETED</span>";
                      }
                      else if ($model->tagging->tagging_status_id==3) {
                          return "<span class='badge btn-warning' style='width:90px;height:20px'>ASSIGNED</span>";
                      }
                      else if ($model->tagging->tagging_status_id==4) {
                          return "<span class='badge btn-danger' style='width:90px;height:20px'>CANCELLED</span>";
                      }
                       
                
                  }else{
                      return "<span class='badge badge-success' style='width:80px!important;height:20px!important;'>PENDING</span>";
                  }
                 
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => $analysistemplate,
                'buttons'=>[
                    'update'=>function ($url, $model) use ($requeststatus,$notified) {
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/analysisreferral/update','id'=>$model->analysis_id,'request_id'=>$model->request_id,'page'=>3]), 'onclick'=>'updateAnalysisReferral('.$model->analysis_id.',this.value,this.title)', 'class' => 'btn btn-primary','title' => 'Update Analysis']);
                        return ($requeststatus > 0 && $notified == 0) ? Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['onclick'=>'updateAnalysisReferral('.$model->analysis_id.','.$model->request_id.',this.title)', 'class' => 'btn btn-primary','title' => 'Update Analysis']) : null;
                    },
                    'delete'=>function ($url, $model) use ($requeststatus,$notified) {
                        $urls = '/lab/analysis/delete?id='.$model->analysis_id;
                        return ($requeststatus > 0 && $notified == 0) ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Analysis','data-pjax'=>'0']) : null;
                       // return Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value'=>Url::to(['/lab/analysis/delete','id'=>$model->analysis_id]), 'class' => 'btn btn-danger']);
                    },
                    'view' => function ($url, $model) use ($requeststatus) {
                        return ($requeststatus > 0) ? Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/analysisreferral/view','id'=>$model->analysis_id]), 'onclick'=>'viewAnalysisReferral(this.value,this.title)', 'class' => 'btn btn-primary','title' => 'View Analysis']) : null;
                    },
                ],
            ],
        ];
            echo GridView::widget([
                'id' => 'analysis-grid',
                'responsive'=>true,
                'dataProvider'=> $analysisdataprovider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'showPageSummary' => true,
                'hover'=>true,
                
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Analysis</h3>',
                    'type'=>'primary',
                    'before'=>($requeststatus > 0 && $notified == 0) ? Html::button('<i class="glyphicon glyphicon-plus"></i> Add Analysis', ['disabled'=>$enableRequest,'value' => $model->request_type_id == 2 ? Url::to(['analysisreferral/create','request_id'=>$model->request_id]) : "",'title'=>'Add Analyses', 'onclick'=> $model->request_type_id == 2 ? $ClickButtonAnalysisReferral : "", 'class' => 'btn btn-success','id' => 'btn_add_analysis'])."   ".
                    Html::button('<i class="glyphicon glyphicon-plus"></i> Add Package', ['disabled'=>$enableRequest,'value' => Url::to(['/services/packagelist/createpackage','id'=>$model->request_id]),'title'=>'Add Package', 'onclick'=>$ClickButton, 'class' => 'btn btn-success','id' => 'btn_add_package'])." ".
                    Html::button('<i class="glyphicon glyphicon-plus"></i> Additional Fees', ['disabled'=>$enableRequest,'value' => Url::to(['/lab/fee/create','id'=>$model->request_id]),'title'=>'Add Additional Fees', 'onclick'=>$ClickButton, 'class' => 'btn btn-success','id' => 'btn_add_fees']) : null,
                   'after'=>false,
                   //'footer'=>($model->request_type_id == 2 || $requeststatus <= 0) ? "":"<div class='row' style='margin-left: 2px;padding-top: 5px'><button ".$disableButton." value='/lab/request/saverequestransaction' ".$btnID." class='btn btn-success'><i class='fa fa-save'></i> Save Request</button>".$EnablePrint."</div>",
                   'footer'=>($model->request_type_id == 2 || $notified == 0) ? "":"<div class='row' style='margin-left: 2px;padding-top: 5px'><button ".$disableButton." value='/lab/request/saverequestransaction' ".$btnID." class='btn btn-success'><i class='fa fa-save'></i> Save Request</button>".$EnablePrint."</div>",
                ],
                'columns' => $analysisgridColumns,
                'toolbar' => [
                ],
            ]);
        ?>
    </div>
    <div class="container">
        <div class="table-responsive">
        <?php
        if($model->request_type_id == 2){
            $requestId = $model->request_id;
            $gridColumns = [
                [
                    //'attribute'=>'sample_code',
                    'attribute'=>'name',
                    'enableSorting' => false,
                    'header' => 'Agency',
                    'contentOptions' => [
                        'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    //'attribute'=>'samplename',
                    'attribute'=>'region',
                    'enableSorting' => false,
                    'header' => 'Region',
                ],
                [
                    //'attribute'=>'description',
                    'attribute'=>'agency_id',
                    'format' => 'raw',
                    'header' => 'Turnaround Time (Estimated)',
                    'enableSorting' => false,
                    'value' => function($data){
                        //return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".date("Y-m-d h:i A",strtotime($data->sampling_date))."</b></span>,&nbsp;".$data->description : $data->description;
                    },
                   'contentOptions' => [
                        'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{notification} {confirm} {sendreferral}',
                    'dropdown' => false,
                    'dropdownOptions' => ['class' => 'pull-right'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'buttons' => [
                        'notification' => function ($url, $data) use ($model,$referralcomp) {
                            //if($model->active == 1){
                            //    return Html::a('<span class="glyphicon glyphicon-bell"></span> Notify', '#', ['class'=>'btn btn-primary','title'=>'Send Notification','onclick' => 'sendNotification(19,11)']);

                            $checkNotify = $referralcomp->checkNotify($model->request_id,$data['agency_id']);
                            $checkActive = $referralcomp->checkActiveLab($model->lab_id,$data['agency_id']);

                            //return $model->lab_id.". .".$data['agency_id'];
                            //exit;
                            if($model->status_id > 0) {
                                switch ($checkNotify) {
                                    case 0:
                                        alert('Not valid request!');
                                        /*return Html::button('<span class="glyphicon glyphicon-bell"></span> Notify', ['value'=>Url::to(['/referrals/referral/notify','request_id'=>$model->request_id,'agency_id'=>$data['agency_id']]), 'onclick'=>'sendNotification(this.value,this.title)', 'class' => 'btn btn-primary','title' => 'Notify Agency']);
                                        break;*/
                                        if($checkActive != 1)
                                        {
                                            return 'Lab not active.';
                                        }
                                    case 1:
                                        if($checkActive == 1){
                                            $noti_message = "";
                                            return Html::button('<span class="glyphicon glyphicon-bell"></span> Notify', ['value'=>Url::to(['/referrals/referral/notify','request_id'=>$model->request_id,'agency_id'=>$data['agency_id']]),'onclick'=>'sendNotification(this.value,this.title)','class' => 'btn btn-primary','title' => 'Notify '.$data['name']]);
                                            //return Html::button('<span class="glyphicon glyphicon-bell"></span> Notify', ['value'=>Url::to(['/referrals/referral/notify','request_id'=>$model->request_id,'agency_id'=>$data['agency_id']]),'id'=>'send-notice','data-toggle'=>'modal','data-target'=>'#exampleModal','class' => 'btn btn-primary','title' => 'Notify Agency']);
                                            //return Html::button('<span class="glyphicon glyphicon-bell"></span> Notify', ['value'=>Url::to(['/referrals/referral/notify','request_id'=>$model->request_id,'agency_id'=>$data['agency_id']]), 'onclick'=>'sendNotification(this.value,this.title)', 'class' => 'btn btn-primary','title' => 'Notify Agency']);
                                            //return Html::button('<span class="glyphicon glyphicon-bell"></span> Notify',['data-confirm'=>"Confirm to notify <b>".$data['name']."</b>. Click OK to proceed.",'class'=>'btn btn-primary','title'=>'Notify '.$data['name'],'data-pjax'=>'0',['value'=>Url::to(['/referrals/referral/notify','request_id'=>$model->request_id,'agency_id'=>$data['agency_id']],'onclick'=>'sendNotification(this.value,this.title)']);
                                            //return Html::button('<span class="glyphicon glyphicon-trash"></span> Notify',['data-confirm'=>" <b>".$data['name']."</b>?",'data-method'=>'post','class'=>'btn btn-danger','title'=>'Delete Sample','data-pjax'=>'0']);
                                        } else {
                                            return '<span class="label label-danger">LAB NOT ACTIVE</span>';
                                        }
                                        break;
                                    case 2: 
                                        return '<span class="text-success">Notice sent.</span>';
                                        break;
                                }
                            } else {
                                return "<span class='label label-danger'>Referral ".$model->status->status."</span>";
                            }
                        },
                    ],
                ],
            ];

            echo GridView::widget([
                'id' => 'agency-grid',
                'dataProvider'=> $agencydataprovider,
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
                    'heading'=>'<h3 class="panel-title">Agency</h3>',
                    'type'=>'primary',
                    //'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['disabled'=>$enableRequest, 'value' => Url::to(['sample/create','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn'])." ".Html::button('<i class="glyphicon glyphicon-print"></i> Print Label', ['disabled'=>!$enableRequest, 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/reports/preview?url=/lab/request/printlabel','request_id'=>$model->request_id]) . "';" ,'title'=>'Print Label',  'class' => 'btn btn-success']),
                    'before'=>'<p class="text-primary"><strong>Note:</strong> Agency that offers the testname and method.</p>',
                    'after'=>false,
                ],
                /*'krajeeDialogSettings' => [ 
                    'options' => ['title' => 'Your Custom'],
                    'overrideYiiConfirm' => true,
                ],*/
                'columns' => $gridColumns,
                'toolbar' => [
                    'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Refresh Grid', [Url::to(['request/view','id'=>$model->request_id])], [
                                'class' => 'btn btn-default', 
                                'title' => 'Refresh Grid'
                            ]),
                    //'{toggleData}',
                ],
            ]);
        }
        ?>
        </div>
    </div>
    <div class="container">
        <div class="table-responsive">
        <?php
        if($model->request_type_id == 2){
           /* $gridColumns = [
                [
                    'attribute'=>'sample_code',
                    'enableSorting' => false,
                    'header' => 'Agency',
                    'contentOptions' => [
                        'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'attribute'=>'samplename',
                    'enableSorting' => false,
                    'header' => 'Region',
                ],
                [
                    'attribute'=>'description',
                    'format' => 'raw',
                    'header' => 'Turnaround Time (Estimated)',
                    'enableSorting' => false,
                    'value' => function($data){
                        return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".date("Y-m-d h:i A",strtotime($data->sampling_date))."</b></span>,&nbsp;".$data->description : $data->description;
                    },
                   'contentOptions' => [
                        'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{notification}',
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
                        'notification' => function ($url, $model) {
                            if($model->active == 1){
                                return Html::a('<span class="glyphicon glyphicon-bell"></span> Notify', '#', ['class'=>'btn btn-primary','title'=>'Send Notification','onclick' => 'sendNotification('.$model->sample_id.')']);
                            } else {
                                return null;
                            }
                        },
                    ],
                ],
            ];

            echo GridView::widget([
                'id' => 'bidding-grid',
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
                    'heading'=>'<h3 class="panel-title">Bidding</h3>',
                    'type'=>'primary',
                    //'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['disabled'=>$enableRequest, 'value' => Url::to(['sample/create','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn'])." ".Html::button('<i class="glyphicon glyphicon-print"></i> Print Label', ['disabled'=>!$enableRequest, 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/reports/preview?url=/lab/request/printlabel','request_id'=>$model->request_id]) . "';" ,'title'=>'Print Label',  'class' => 'btn btn-success']),
                    'before'=>'<p class="text-primary"><strong>Note:</strong> Agency who participated the bidding.</p>',
                    'after'=>false,
                ],
                'columns' => $gridColumns,
                'toolbar' => [
                    'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Refresh Grid', [Url::to(['request/view','id'=>$model->request_id])], [
                                'class' => 'btn btn-default', 
                                'title' => 'Refresh Grid'
                            ]),
                    //'{toggleData}',
                ],
            ]);*/
        }
        ?>
        </div>
    </div>
</div>
    <!-- Button trigger modal -->
    <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Launch demo modal
    </button>-->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class='alert alert-danger' style='border:2px #dd4b39 dotted;margin:auto;font-size:13px;text-align:justify;text-justify:inter-word;color:#8a6d3b;'>
                <strong>Warning:</strong><br />
                <ol>
                    <li>Make sure the selected laboratory is correct before you notify. Is it really Chem Lab, Micro Lab, Metro Lab, etc.?</li>
                    <li>If you are notifying to <strong><i>DOST-ITDI</i></strong> for chemical analysis, make sure you 
                    have selected either Organic Chemistry Laboratory (OCS) or Inorganic Chemistry Laboratory (ICS).</li>
                </ol>
                If you need assistance, please contact the web administrator.
            </div>
            <p class='note' style='margin:15px 0 0 15px;font-weight:bold;color:#0d47a1;font-size:13px;'>Are you sure you want to send notification to <span class='agency-name' style='color:#000000;'><span style='font-size:10px;color:#757575;'>...Loading Agency...</span></span>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">

    $('#sample-grid tbody td').css('cursor', 'pointer');
    function updateSample(id){
       var url = '/lab/sample/update?id='+id;
        $('.modal-title').html('Update Sample');
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    function viewRemarkSample(id){
       var url = '/lab/sample/cancel?id='+id;
        $('.modal-title').html('View Cancel Remark');
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    function cancelSample(id){
       var url = '/lab/sample/cancel?id='+id;
        $('.modal-title').html('Cancel Sample');
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    function addSample(url,title){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       //var url = '/lab/sample/update?id='+id;
        $(".modal-title").html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    function addAnalysisReferral(url,title){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       //var url = '/lab/sample/update?id='+id;
        $(".modal-title").html(title);
        $('#modalAnalysis').modal('show')
            .find('#modalContent')
            .load(url);
    }
    //function updateAnalysisReferral(id,url,title){
    function updateAnalysisReferral(id,requestId,title){
        //var url = '/lab/analysisreferral/update?id='+id;
        //var url = '/lab/analysisreferral/update?id='+id+'&request_id='+requestId;
        //var url = '/lab/analysisreferral/getdefaultpage?analysis_id='+id;
        //$('.modal-title').html(title);
        //$('#modalAnalysis').modal('show')
        //    .find('#modalContent')
        //    .load(url);
        /*$.ajax({
            url: '/lab/analysisreferral/getdefaultpage',
            //dataType: 'json',
            method: 'GET',
            data: {analysis_id:analysisId},
            //data: $(this).serialize(),
            success: function (data, textStatus, jqXHR) {
                $('.image-loader').removeClass("img-loader");
                //$('#methodreference').html(data);
                var url = '/lab/analysisreferral/update?id='+id+'&request_id='+requestId+'&perpage='data.count_page;
                $('.modal-title').html(title);
                $('#modalAnalysis').modal('show')
                    .find('#modalContent')
                    .load(url);
            },
            beforeSend: function (xhr) {
                $('.image-loader').addClass("img-loader");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>Error Encountered!</p>");
            }
        });*/
            $.ajax({
                url: '/lab/analysisreferral/getdefaultpage?analysis_id='+id,
                success: function (data) {
                    $('.image-loader').removeClass('img-loader');
                    //alert(data);
                    var url = '/lab/analysisreferral/update?id='+id+'&request_id='+requestId+'&page='+data;
                    $('.modal-title').html(title);
                    $('#modalAnalysis').modal('show')
                        .find('#modalContent')
                        .load(url);
                },
                beforeSend: function (xhr) {
                    $('.image-loader').addClass('img-loader');
                }
            });
    }
    function viewAnalysisReferral(url,title){
        $('.modal-title').html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }

    function sendNotification(url,title){
        //var url = '/lab/sample/update?id='+id;
        //$('.modal-title').html(title);
        //$('#modal').modal('show')
        //.find('#modalContent')
        //.load(url);

        //$('.modal-title').html(title);
        //$('#tae').modal('show')
        //    .find('#modalContent');
            //.load();
        var str = title.slice(7);
        var header_title = '';

        //alert(title.length);
        if(title.length > 73){
            header_title = title.slice(0, 70) + '...';
        } else {
            header_title = title;
        }

        if(str.length > 0){
            //alert('ggg');
            //$("p.note span.agency-name").html(agency_name);
            //alert(agency_name);
            var agency_name = str;
        } else {
            var agency_name = "<span style='font-size:10px;color:#757575;'>...No agency to be displayed...</span>";
        }

        BootstrapDialog.show({
            title: "<span class='glyphicon glyphicon-send'></span>&nbsp;&nbsp;" + header_title,
            message: "<div class='alert alert-danger' style='border:2px #ff3300 dotted;margin:auto;font-size:13px;text-align:justify;text-justify:inter-word;'>"
                +"<strong style='font-size:16px;'>Warning:</strong><br>"
                +"<ol>"
                +"<li>Make sure the selected laboratory is correct before you notify. Is it really Chem Lab, Micro Lab, Metro Lab, etc.?</li>"
                +"<li>If you are notifying to <strong><i>DOST-ITDI</i></strong> for chemical analysis, make sure you have selected either Organic Chemistry Laboratory (OCS) or Inorganic Chemistry Laboratory (ICS).</li>"
                +"</ol>"
                +"<p style='font-weight:bold;font-size:13px;'><span class='glyphicon glyphicon-info-sign' style='font-size:17px;'></span>&nbsp;If you need assistance, please contact the web administrator.</p>"
                +"</div>"
                +"<p class='note' style='margin:15px 0 0 15px;font-weight:bold;color:#0d47a1;font-size:14px;'>Are you sure you want to send notification to <span class='agency-name' style='color:#000000;'>"+agency_name+"</span>?</p>",
            /*message: "<div class='alert alert-danger' style='border:2px #dd4b39 dotted;margin:auto;font-size:13px;text-align:justify;text-justify:inter-word;color:#8a6d3b;'>
                <strong>Warning:</strong><br>
                <ol>
                    <li>Make sure the selected laboratory is correct before you notify. Is it really Chem Lab, Micro Lab, Metro Lab, etc.?</li>
                    <li>If you are notifying to <strong><i>DOST-ITDI</i></strong> for chemical analysis, make sure you 
                    have selected either Organic Chemistry Laboratory (OCS) or Inorganic Chemistry Laboratory (ICS).</li>
                </ol>
                If you need assistance, please contact the web administrator.
            </div>
            <p class='note' style='margin:15px 0 0 15px;font-weight:bold;color:#0d47a1;font-size:13px;'>Are you sure you want to send notification to <span class='agency-name' style='color:#000000;'><span style='font-size:10px;color:#757575;'>...Loading Agency...</span></span>?</p>",*/
            buttons: [
                /*{
                    label: 'Button 1',
                    title: 'Mouse over Button 1'
                },*/
                {
                    label: 'Send',
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    /*data: {
                        js: 'btn-confirm',
                        'user-id': '3'
                    },*/
                    action: function(thisDialog){
                        //alert('Hi Orange!');
                        thisDialog.close();
                        $('.modal-title').html(header_title);
                        $('#modal').modal('show')
                            .find('#modalContent')
                            .load(url);
                    }
                }, 
                /*{
                    icon: 'glyphicon glyphicon-ban-circle',
                    label: 'Button 3',
                    title: 'Mouse over Button 3',
                    cssClass: 'btn-warning'
                },*/ 
                {
                    label: 'Close',
                    action: function(thisDialog){
                        thisDialog.close();
                    }
                }
            ]
        });

        //krajeeDialog.dialog('#referral', function (result) {
        //    if (result) { // ok button was pressed
                // execute your code on dialog confirmation
        //    } else { // dialog dialog was cancelled
                // execute your code for cancellation
          //  }
        //});



        /*connnn.dialog('<i>dada</i>', function (result) {
            if (result) { // ok button was pressed
                // execute your code on dialog confirmation
            } else { // dialog dialog was cancelled
                // execute your code for cancellation
            }
        });*/









        //BootstrapDialog.show("Hold On! This is a Krajee alert!");
        //krajeeDialog.confirm("<p class='text-danger' style='font-weight:bold;'>No sample selected!</p>");
        //connnn.alert("<p class='text-danger' style='font-weight:bold;'>No sample selected!</p>");
        //connnn.prompt({label:'Provide reason', placeholder:'Upto 30 characters...'}, function (result) {
        //if (result) {
            //alert('Great! You provided a reason: \n\n' + result);
        //} else {
            //alert('Oops! You declined to provide a reason!');
        //}
    //});
        // JS Code
        //connnn.confirm("Are you really sure you want to do this?", function (result) {
            //{title : title},
           // if (result) { // ok button was pressed
                // execute your code for confirmation
            //    connnn.alert('TAE!');
            //} else { // confirmation was cancelled
                // execute your code for cancellation
            //}
        //});

        //alert("<p class='text-danger' style='font-weight:bold;'>No Method selected!</p>");
        // JS Code
        /*krajeeDialog.dialog('This is a custom dialog', function (result) {
            if (result) { // ok button was pressed
                // execute your code on dialog confirmation
            } else { // dialog dialog was cancelled
                // execute your code for cancellation
            }
        });*/
        /*krajeeDialog.dialog({
            label:'Provide reason',
            placeholder:'Upto 30 characters...',
            options : {
                title : 'sss',
            },
        }, function(out){
            if (out) {
                alert('Yes'); // or do something based on the value of out
            }
        });*/
        /*$.ajax({
            url: url,
            success: function (data) {
                $('.image-loader').removeClass('img-loader');
                var url = '/lab/analysisreferral/update?id='+id+'&request_id='+requestId+'&page='+data;
                $('.modal-title').html(title);
                $('#modalAnalysis').modal('show')
                    .find('#modalContent')
                    .load(url);
            },
            beforeSend: function (xhr) {
                $('.image-loader').addClass('img-loader');
            }
        });*/
         //e.preventDefault();
            //var modal = $('#modal').modal('show');
            //modal.find('.modal-body').load($('.modal-dialog'));
            //var that = $(this);
            //var id = that.data('id');
            //var name = that.data('name');
            //modal.find('.modal-title').text('Supprimer la ressource');

            /*$('#delete-confirm').click(function(e) {
                e.preventDefault();
                window.location = 'delete?id='+id;
            });*/
             /*krajeeDialog.prompt({label:'Estimated Turnaround Time', placeholder:'Upto 30 characters...'}, function (result) {
                if (result) {
                    alert('Great! You provided a reason: \n\n' + result);
                } else {
                    alert('Oops! You declined to provide a reason!');
                }
            });*/
    }

    function notify(){

    }
    
</script>

<?php
//kartik\dialog\DialogAsset::register($this);
$this->registerJs("
    /*$('#your-btn-id').on('click', 
       function(){
            krajeeDialog.prompt({label:'Provide reason', placeholder:'Upto 30 characters...'}, function (result) {
                if (result) {
                    alert('Great! You provided a reason: \n\n' + result);
                } else {
                    alert('Oops! You declined to provide a reason!');
                }

            });
            $('#dia').modal('open');
        });*/
");
Modal::begin([
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'bodyOptions'=>[
            'class' => 'modal-body',
            'style'=>'padding-bottom: 20px',
        ],
        'options' => [
            'id' => 'modalAnalysis',
            'tabindex' => false, // important for Select2 to work properly
            //'tabindex' => 0, // important for Select2 to work properly
        ],
        'header' => '<h4 class="fa fa-clone" style="padding-top: 0px;margin-top: 0px;padding-bottom:0px;margin-bottom: 0px"> <span class="modal-title" style="font-size: 16px;font-family: \'Source Sans Pro\',sans-serif;"></span></h4>',
        'size' => Modal::SIZE_LARGE,
    ]);
    echo "<div>";
    echo "<div class='modal-scroll'><div id='modalContent' style='margin-left: 5px;'><div style='text-align:center;'><img src='/images/img-loader64.gif' alt=''></div></div>";
    echo "<div>&nbsp;</div>";
    echo "</div></div>";
Modal::end();
Modal::begin([
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'bodyOptions'=>[
            'class' => 'modal-body',
            'style'=>'padding-bottom: 20px',
        ],
        'options' => [
            'id' => 'tae',
            'tabindex' => false, // important for Select2 to work properly
            //'tabindex' => 0, // important for Select2 to work properly
        ],
        'header' => '<h4 class="fa fa-clone" style="padding-top: 0px;margin-top: 0px;padding-bottom:0px;margin-bottom: 0px"> <span class="modal-title" style="font-size: 16px;font-family: \'Source Sans Pro\',sans-serif;"></span></h4>',
        //'size' => Modal::SIZE_SMALL,
    ]);
    echo "<div>";
    echo "<div class='modal-scroll'>
            <div id='modalContent' style='margin-left: 5px;'><div style='text-align:center;'>
            <!--<img src='/images/img-loader64.gif' alt=''></div>-->
            <!--<div id='referral' class='alert alert-info' style='width:90%;padding:5px;'>-->
            <div class='alert alert-danger' role='alert' style='border:2px #FF8800 dotted;margin:auto;font-size:13px;text-align:justify;text-justify:inter-word;color:#8a6d3b;'>
                <strong>Warning:</strong><br />
                <ol>
                    <li>Make sure the selected laboratory is correct before you notify. Is it really Chem Lab, Micro Lab, Metro Lab, etc.?</li>
                    <li>If you are notifying to <strong><i>DOST-ITDI</i></strong> for chemical analysis, make sure you 
                    have selected either Organic Chemistry Laboratory (OCS) or Inorganic Chemistry Laboratory (ICS).</li>
                </ol>
                If you need assistance, please contact the web administrator.
            </div>
            <p class='note' style='margin:15px 0 0 15px;font-weight:bold;color:#0d47a1;font-size:13px;'>Are you sure you want to send notification to <span class='agency-name' style='color:#000000;'><span style='font-size:10px;color:#757575;'>...Loading Agency...</span></span>?</p>
        </div>
        <!--</div>-->";
    echo "<div>&nbsp;</div>";
    echo "</div></div>";
Modal::end();
// Confirmation modal before proceeding
//echo kartik\dialog\Dialog::widget();
//echo kartik\dialog\Dialog::widget([
   //'libName' => 'krajeeDialogCust', // optional if not set will default to `krajeeDialog`
   //'options' => ['draggable' => true, 'closable' => true], // custom options
//]);
//'krajeeDialogSettings' => [
//    'overrideYiiConfirm' => false
//];
//echo Dialog::overrideYiiConfirm => false;
/*echo Html::a(
    'Delete', 
    ['/item/delete1', 'id' =>'1'], 
    [
        'data-confirm' => 'Are you sure to delete this item?',
        'data-method' => 'post'
    ]
);*/
//echo Dialog::widget(['overrideYiiConfirm' => true]);
/*echo Dialog::widget([
    'libName' => 'connnn', // a custom lib name
    //'id' => 'confirmDialog',
    'overrideYiiConfirm' => false,
    //'title' => Yii::t('kvdialog', 'Confirmation'),
    //    'btnOKClass' => 'btn-warning',
    //    'btnOKLabel' => Dialog::ICON_OK . ' ' . Yii::t('kvdialog', 'Ok'),
    //    'btnCancelLabel' => Dialog::ICON_CANCEL . ' ' . Yii::t('kvdialog', 'Cancel')
    //'buttonOKClass' => 'btn-warning',
    //'btnOKLabel' => Dialog::ICON_OK . ' ' . Yii::t('kvdialog', 'Ok'),
    //'btnCancelLabel' => Dialog::ICON_CANCEL . ' ' . Yii::t('kvdialog', 'Cancel'),
    'options' => [  // customized BootstrapDialog options
        //'size' => Dialog::SIZE_LARGE,
        'type' => Dialog::TYPE_PRIMARY, // bootstrap contextual color
        //'title' => "<i class='glyphicon glyphicon-send' style='font-size:20px'></i> Notification",
        //'buttonSend' = 'Send',
        //'buttonLabel' => 'Close',
        'buttons' => [
            [
                //'id' => 'cust-btn-1',
                'label' => 'Button 1',
                'action' => new JsExpression("function(dialog) {
                    dialog.setTitle('Title 1');
                    dialog.setMessage('This is a custom message for button number 1');
                }")
                //'label' => Yii::t('kvdialog', 'Close'),
                //'icon' => Dialog::ICON_CANCEL
            ],
            [
                //'id' => 'cust-btn-2',
                'label' => 'Button 2',
                'action' => new JsExpression("function(dialog) {
                    dialog.setTitle('Title 2');
                    dialog.setMessage('This is a custom message for button number 2');
                }")
                //'label' => Yii::t('kvdialog', 'Kamote'),
                //'icon' => Dialog::ICON_OK
                //'cssClass' => 'btn-primary'
            ],
        ]
    ],
]);*/
?>
<style type="text/css">
/* Absolute Center Spinner */
.img-loader {
    position: fixed;
    z-index: 999;
    /*height: 2em;
    width: 2em;*/
    height: 64px;
    width: 64px;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: url('/images/img-loader64.gif');
    background-repeat: no-repeat;
}
/* Transparent Overlay */
.img-loader:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
}
</style>