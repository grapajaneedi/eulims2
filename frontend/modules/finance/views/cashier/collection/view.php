<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use common\models\finance\Collection;
use common\components\Functions;
use common\models\finance\CancelledOp;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Op */

$this->title = 'Order of Payment';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Cashier', 'url' => ['/finance/cashier']];
$this->params['breadcrumbs'][] = ['label' => 'Collection', 'url' => ['/finance/cashier/collection']];
$this->params['breadcrumbs'][] = 'View';
//Check if exist collection to avoid Error: Edit by Nolan 7/10/2018
if($model->collection){
    $CollectionAmount=$model->collection->amount;
}else{
    $CollectionAmount=0.00;
}
$bal=($model->total_amount) -($CollectionAmount);
//echo $model->total_amount;
//exit;
if($bal <> 0){
    $footer="<div class='row' style='margin-left: 2px;'><button value='/finance/cashier/create-receipt?op_id=$model->orderofpayment_id' id='btnCreateReceipt' class='btn btn-success' title='Receipt from OP'><i class='fa fa-save'></i> Create Receipt</button></div>";                    
}
else{
    $footer=Html::a('View Receipt', ['/finance/cashier/view-receipt?receiptid='.$model->created_receipt], ['target'=>'_blank','class'=>'btn btn-primary']);
}

$sweetalert = new Functions();

if($model->collection->payment_status_id==0){
    $CancelButton='';
    $CancelClass='request-cancelled';
    $BackClass='background-cancel';
}else{
    $CancelClass='cancelled-hide';
    $BackClass='';
    $CancelButton='';
}
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
                        'value'=>$model->customer->customer_name,
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
                        'value'=>$model->customer->address,
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
                    'label'=>' ',
                    'format'=>'raw',
                    'value'=>' ',
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
                        'label'=>'Collection',
                        'format'=>'raw',
                         'format' => ['decimal', 2],
                        // Check if Collection Exist (edited: 7/9/2018)
                        'value' => $model->collection ? $model->collection->sub_total : 0.00,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Balance',
                        'format'=>'raw',
                        'value' => $bal,
                        'format' => ['decimal', 2],
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
                [
                    'attribute'=>'details',
                    'enableSorting' => false,
                    'contentOptions' => [
                        'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                    //'hAlign' => 'right',
                    'pageSummary' => '<span style="float:right;">Total</span>',
                ],
                [
                    'attribute'=>'amount',
                    'enableSorting' => false,
                    
                    'contentOptions' => [
                        'style'=>'max-width:80px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                    'hAlign' => 'right', 
                    'vAlign' => 'middle',
                    'width' => '7%',
                    'format' => ['decimal', 2],
                    'pageSummary' => true
                ],
               
              
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
                    'after'=>false,
                    
                    'footer'=>$footer,
       
                ],
                'columns' => $gridColumns,
               
            ]);
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#btnCreateReceipt').click(function(){
        $('.modal-title').html($(this).attr('title'));
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
  
</script>