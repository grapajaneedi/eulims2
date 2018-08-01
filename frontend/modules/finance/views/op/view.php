<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use common\models\finance\Collection;
use common\models\finance\CancelledOp;
use common\components\Functions;
use common\models\finance\PaymentStatus;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Op */

$this->title = 'Order of Payment';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Order of Payment', 'url' => ['index']];
$allow_cancel=false;
$button_paymentitem=Html::button('<i class="glyphicon glyphicon-plus"></i> Add Paymentitem', ['value' => Url::to(['add-paymentitem','opid'=>$model->orderofpayment_id,'customerid'=>$model->customer_id]),'title'=>'Add Payment Item', 'onclick'=>'addPaymentitem(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']);
if(Yii::$app->user->can('allow-cancel-op')){
   $allow_cancel=true; 
}
if(Yii::$app->user->can('allow-create-receipt')){
    if($model->receipt_id == null){
       $receipt_button="<button type='button' value='/finance/cashier/create-receipt?op_id=$model->orderofpayment_id' id='btnCreateReceipt2' style='float: right;' class='btn btn-success' title='Receipt from OP' onclick='addReceipt(this.value,this.title)'><i class='fa fa-save'></i> Create Receipt</button>";                    
    
        //$receipt_button="<button onclick='alert(\"hello world\")'>click</button>";
    }
    else{
        $receipt_button="<button type='button' value='/finance/cashier/view-receipt?receiptid=$model->receipt_id' id='Receipt2' style='float: right;' class='btn btn-success' onclick='location.href=this.value'><i class='fa fa-eye'></i> View Receipt</button>";                    
    
        //$receipt_button=Html::a('View Receipt', ['/finance/cashier/view-receipt?receiptid='.$model->receipt_id], ['target'=>'_blank','class'=>'btn btn-primary']);
    }
}
else{
    $receipt_button="";
}
$receipt_id=$model->receipt_id;
//}
$sweetalert = new Functions();
$footer="<div class='alert alert-info' style='background: #d9edf7 !important;margin-top: 1px !important;width:550px;'>
                 <a href='#' class='close' data-dismiss='alert'>&times;</a>
                 <p class='note' style='color:#265e8d'> <strong>For partial payment, please click on each amount and modify accordingly.</strong><br />
                 <strong>Note!</strong> Only amount with _ _ _ can be modified. </p>
             </div>";
if($model->payment_status_id==0){
    $CancelButton='';
    $CancelClass='request-cancelled';
    $BackClass='background-cancel';
}else{
    if($model->receipt_id == null){
        $CancelClass='cancelled-hide';
        $BackClass='';
        $Func="LoadModal('Cancel Order of Payment','/finance/cancelop/create?op=".$model->orderofpayment_id."',true,500)";
        $CancelButton=$allow_cancel ? '<button id="btnCancel" onclick="'.$Func.'" type="button" style="float: right;padding-right:5px" class="btn btn-danger"><i class="fa fa-remove"></i> Cancel Order of Payment</button>' : "";
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

$print_button=Html::button('<span class="glyphicon glyphicon-download"></span> Print OP', ['value'=>'/finance/op/printview?id='.$model->orderofpayment_id, 'class' => 'btn btn-small btn-primary','title' => Yii::t('app', "Print Report"),'onclick'=>"location.href=this.value"]);

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
                    'label'=>'Order of Payment Details '.$CancelButton.$receipt_button,
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
                        'value'=>$model->collectiontype ? $model->collectiontype->natureofcollection : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Address',
                        'format'=>'raw',
                        'value'=>$model->customer ? $model->customer->completeaddress : "",
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
                    //'asPopover' => true,
                    'attribute' => 'amount', 
                    'readonly' => function($model, $key, $index, $widget) {
                        if($model->status == 2){
                            return true;
                        }
                        else{
                            return false;
                        }
                         // do not allow editing of inactive records
                     },
                    'editableOptions' => [
                        'header' => 'Amount', 
                        'size'=>'s',
                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                        'options' => [
                            'pluginOptions' => ['min' => 1]
                        ],
                        'placement'  => 'left',
                        'formOptions'=>['action' => ['/finance/op/updateamount']],
                    ],
                    'hAlign' => 'left', 
                    'vAlign' => 'middle',
                    'width' => '25%',
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
                    'before'=>$model->receipt_id ? "" : $footer .$button_paymentitem ."&nbsp;&nbsp;&nbsp;".$print_button,
                ],
                'columns' => $gridColumns,
               
            ]);
             ?>
            
             
        </div>
       
    </div>
</div>
<script type="text/javascript">
    function addReceipt(url,title){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       //var url = '/lab/sample/update?id='+id;
        $(".modal-title").html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    
    function addPaymentitem(url,title){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       //var url = '/lab/sample/update?id='+id;
        $(".modal-title").html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
</script>