<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use common\models\finance\Collection;
use common\models\finance\CancelledOp;
use common\components\Functions;
use common\models\finance\PaymentStatus;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Op */

$this->title = 'Order of Payment';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Order of Payment', 'url' => ['index']];

$bal=($model->total_amount) -($model->collection->sub_total);
//}
$sweetalert = new Functions();

if($model->collection->payment_status_id==0){
    $CancelButton='';
    $CancelClass='request-cancelled';
    $BackClass='background-cancel';
}else{
    if($model->created_receipt == 0){
        $CancelClass='cancelled-hide';
        $BackClass='';
        $Func="LoadModal('Cancel Order of Payment','/finance/cancelop/create?op=".$model->orderofpayment_id."',true,500)";
        $CancelButton='<button id="btnCancel" onclick="'.$Func.'" type="button" style="float: right" class="btn btn-danger"><i class="fa fa-remove"></i> Cancel Order of Payment</button>';
    }
    else{
        $CancelClass='cancelled-hide';
        $BackClass='';
        $CancelButton='';
    }
    
}

//$Request_Ref=$model->request_ref_num;
$Cancelledop= CancelledOp::find()->where(['orderofpayment_id'=>$model->orderofpayment_id])->one();
if($Cancelledop){
    $transnum=$Cancelledop->transactionnum;
    $Reasons=$Cancelledop->reason;
    $DateCancelled=date('m/d/Y h:i A', strtotime($Cancelledop->cancel_date));
    $CancelledBy=$sweetalert->GetProfileName($Cancelledop->cancelledby);
}else{
    $Reasons='&nbsp;';
    $DateCancelled='';
    $CancelledBy='';
    $transnum='';
}
/*
if($model->created_receipt == 0){
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
*/
?>
<div class="orderofpayment-view" style="position:relative;">
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
                    <th style="background-color: lightgray">Transaction #</th>
                    <td><?= $transnum ?></td>
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
   <div class="container">
    <?= DetailView::widget([
        'model'=>$model,
        'responsive'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<i class="glyphicon glyphicon-book"></i> Order of Payment: ' . $model->transactionnum,
            'type'=>DetailView::TYPE_PRIMARY,
        ],
        'buttons1' => '',
        'attributes' => [
            [
                    'group'=>true,
                    'label'=>'Order of Payment Details '.$CancelButton,
                    'rowOptions'=>['class'=>'info']
            ],
            [
                'columns' => [
                    [
                        'label'=>'Transaction Number',
                        'format'=>'raw',
                        'value'=>$model->transactionnum,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Customer Name',
                        'format'=>'raw',
                        'value'=>$model->customer ? $model->customer->customer_name : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
            [
                'columns' => [
                    [
                        'label'=>'Collection Type',
                        'format'=>'raw',
                        'value'=>$model->collectiontype->natureofcollection,
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
                        'label'=>'Date',
                        'format'=>'raw',
                        'value'=>$model->order_date,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true,
                        'hAlign'=>'left',
                  ],
                  [
                    //'attribute'=>'request_datetime',
                    'label'=>'',
                    'format'=>'raw',
                    'value'=>"",
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                  ],
              ],
           ],
          
        ],
    ]) ?>
   </div>
    <div class="container">
        <div class="table-responsive">
             <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn',
                  //'pageSummary' => false,  
                ],
                [
                    'attribute'=>'details',
                    'enableSorting' => false,
                    'contentOptions' => [
                        'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                    //'hAlign' => 'right',
                    'pageSummary' => '<span style="float:right;">Total:</span>',
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'refreshGrid'=>true,
                    'attribute' => 'amount', 
//                    'readonly' => function($model, $key, $index, $widget) {
//                        return (!$model->status); // do not allow editing of inactive records
//                     },
                    'editableOptions' => [
                        'header' => 'Amount', 
                        'size'=>'s',
                       // 'hAlign' => 'center',
                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                        'options' => [
                            'pluginOptions' => ['min' => 0, 'max' => 5000]
                        ],
                        'formOptions'=>['action' => ['/finance/op/updateamount']],
                    ],
                    'hAlign' => 'left', 
                    'vAlign' => 'middle',
                    'width' => '25%',
                    'format' => ['decimal', 2],
                    'pageSummary' => true
                ],
                
                /*
                [
                    'attribute'=>'amount',
                    'enableSorting' => false,
                    'contentOptions' => [
                       // 'style'=>'max-width:80px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                    'hAlign' => 'right', 
                    'vAlign' => 'middle',
                    'width' => '20%',
                    'format' => ['decimal', 2],
                    'pageSummary' => true
                ], 
                [
                    'attribute'=>'status',
                    'format'=>'raw',
                    'enableSorting' => false,
                    'contentOptions' => [
                        'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                    'value'=>function($model){
                    $paymentitem= PaymentStatus::find()->where(['payment_status_id'=>$model->status])->one();
                    if($paymentitem){
                       return "<button class='btn ".$paymentitem['class']." btn-block'><span class=".$paymentitem['icon']."></span>".$paymentitem['payment_status']."</button>"; 
                    }else{
                       return "<button class='btn btn-primary btn-block'>Unpaid</button>"; 
                    }
                   //
                     },   
                    'width' => '10%', 
                ],*/
               
              ];
              
             echo GridView::widget([
                'id' => 'paymentitem-grid',
                'dataProvider'=> $paymentitemDataProvider,
                'pjax'=>true,
                'export'=> false,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'showPageSummary' => true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Item(s)</h3>',
                    'type'=>'primary',
                ],
                'columns' => $gridColumns,
               
            ]);
             ?>
        </div>
    </div>
</div>
