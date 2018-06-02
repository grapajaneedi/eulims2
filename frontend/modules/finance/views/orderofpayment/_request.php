<?php
use kartik\grid\GridView;
use yii\helpers\Html;
$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
      // alert(this.value);
        var keys = $('#grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
        $("#orderofpayment-requestids").val(keys.join());
        $.post({
            url: '/finance/orderofpayment/calculate-total', // your controller action
            data: {keylist: keylist},
            success: function(data) {
                 var tot=parseFloat(data);
                 var total=CurrencyFormat(tot,2);
                 $('#total').html(total);
              
            },
        });
   });    
   $(".select-on-check-all").change(function(){
        var keys = $('#grid').yiiGridView('getSelectedRows');
        $("#orderofpayment-requestids").val(keys.join());
   });
SCRIPT;
$this->registerJs($js);
?>

 <?php 
 $val=123456;
 
    $gridColumn = [
        [
            'class' => '\kartik\grid\SerialColumn',
            
         ],
         [
            'class' => '\kartik\grid\CheckboxColumn',
            
         ],
        'request_ref_num',
        [
            'attribute'=>'request_datetime',
            'pageSummary' => '<span style="float:right;">Total</span>',
        ],
        [
            'attribute'=>'total',
            'enableSorting' => false,
            'contentOptions' => [
                'style'=>'max-width:80px; overflow: auto; white-space: normal; word-wrap: break-word;'
            ],
            'hAlign' => 'right', 
            'vAlign' => 'middle',
            'width' => '7%',
            'format' => ['decimal', 2],
            'pageSummary' => '<span id="total">0.00</span>',
        ],
         /*[
            'attribute'=>'selected_request',
            'pageSummary' => '<span style="float:right;">Total</span>',
        ],*/
      
        
    ];
?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'grid',
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
            'heading'=>'<h3 class="panel-title">Request</h3>',
            'type'=>'primary',
            //'footer'=> false,
         ],
         'columns' =>$gridColumn,
         'showPageSummary' => true,
         /*'afterFooter'=>[
             'columns'=>[
                 'content'=>'Total Selected'
             ],
             
         ],*/
    ]); ?>

