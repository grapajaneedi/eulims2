<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */

$this->title = $model->request_id;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
//Modal::begin([
    //'headerOptions' => ['id' => 'modalSampleheader'],
    //'size' => 'modal-sm',
    //'tabindex' => false,
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
   // 'options' => [
 //       'id' => 'sampleModal',
  //      'tabindex' => false // important for Select2 to work properly
  // ],
//]);
//echo "<div id='modalContent'><div style='text-align:center;'><img src='/images/img-loader64.gif'></div></div>";
//Modal::end();


?>

<div class="request-view">
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <!-- <p>
        <?= Html::a('Update', ['update', 'id' => $model->request_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->request_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

   <!--  <?php /*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'request_id',
            'request_ref_num',
            'request_datetime:datetime',
            'rstl_id',
            'lab_id',
            'customer_id',
            'payment_type_id',
            'modeofrelease_id',
            'discount',
            'discount_id',
            'purpose_id',
            'or_id',
            'total',
            'report_due',
            'conforme',
            'receivedBy',
            'created_at',
            'posted',
            'status_id',
        ],
    ])*/ ?> -->
    <div class="container">
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
                    'label'=>'Request Details',
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
                            //'attribute'=>'request_datetime',
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
                            //'attribute'=>'request_datetime',
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
                            //'attribute'=>'request_datetime',
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
                            //'attribute'=>'request_datetime',
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
                            //'attribute'=>'request_ref_num', 
                            'label'=>'OR No.',
                            'value'=>'',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            //'attribute'=>'request_datetime',
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
                            //'attribute'=>'request_ref_num', 
                            'label'=>'OR Date',
                            'value'=>'',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            //'attribute'=>'request_datetime',
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
                            //'label'=>'Request Reference Number',
                            'format'=>'raw',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'conforme',
                            //'label'=>'Conforme',
                            'format'=>'raw',
                            //'value'=>$model->customer->customer_name,
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
                //['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'request_id',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'request_ref_num',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'report_due',
                    'enableSorting' => false,
                ],
            ];

            echo GridView::widget([
                'id' => 'request-grid',
                'dataProvider'=> $dataProvider,
                'summary' => '',
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                //'filterModel' => $searchModel,
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Samples</h3>',
                    'type'=>'primary',
                    //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['/lab/sample/create','request_id'=>$model->request_id], ['class' => 'btn btn-success']),
                    'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['value' => Url::to(['sample/create','request_id'=>1]),'title'=>'Add Sample', 'class' => 'btn btn-success','id' => 'modalBtn']),
                    'after'=>'',
                    'footer'=>false,
                ],
                'columns' => $gridColumns,
                'toolbar' => [],
                /*'toolbar' => [
                    [
                        'content'=>
                            Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                                'type'=>'button', 
                                //'title'=>Yii::t('kvgrid', 'Add Book'), 
                                'class'=>'btn btn-success'
                            ]) . ' '.
                            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['request-grid'], [
                                'class' => 'btn btn-default', 
                                //'title' => Yii::t('kvgrid', 'Reset Grid')
                            ]),
                    ],
                    //'{export}',
                    //'{toggleData}'
                ],*/
            ]);
        ?>
        </div>
    </div>
    <div class="container">
        <?php
            $gridColumns = [
                //['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'request_id',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'request_ref_num',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'report_due',
                    'enableSorting' => false,
                ],
            ];

            echo GridView::widget([
                'id' => 'request-grid',
                'dataProvider'=> $dataProvider,
                'summary' => '',
                'responsive'=>true,
                'hover'=>true,
                //'filterModel' => $searchModel,

                'panel' => [
                    'heading'=>'<h3 class="panel-title">Analyses</h3>',
                    'type'=>'primary',
                    //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add Analysis', ['/lab/analysis/create'], ['class' => 'btn btn-success'],['id' => 'modalBtn']),
                    'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Analysis', ['value' => Url::to(['sample/create','request_id'=>1]),'title'=>'Add Analysis', 'class' => 'btn btn-success','id' => 'modalBtn'])."   ".
                    Html::button('<i class="glyphicon glyphicon-plus"></i> Add Package', ['value' => Url::to(['sample/create','request_id'=>1]),'title'=>'Add Package', 'class' => 'btn btn-success','id' => 'modalBtn'])."   ".
                    Html::button('<i class="glyphicon glyphicon-plus"></i> Add other Services', ['value' => Url::to(['sample/create','request_id'=>1]),'title'=>'Add Other Services', 'class' => 'btn btn-success','id' => 'modalBtn']),
                   
                  //  'after'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Analysis', ['value' => Url::to(['sample/create','request_id'=>1]),'title'=>'Add Analysis', 'class' => 'btn btn-success','id' => 'modalBtn']),
                    'footer'=>false,
                ],
                'columns' => $gridColumns,
                'toolbar' => [],
            ]);
        ?>
    </div>
</div>
<script type="text/javascript">
   $("#modalBtn").click(function(){
        $(".modal-title").html($(this).attr('title'));
        $("#modal").modal('show')
        //$("#sampleModal").modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
</script>

<?php

?>