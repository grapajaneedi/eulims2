<?php
use kartik\grid\GridView;
use yii\helpers\Html;
$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
      // alert(this.value);
        var keys = $('#grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
        $("#op-requestids").val(keys.join());
        $.post({
            url: '/finance/op/calculate-total?id='+keylist, // your controller action
          // data: {keylist: keylist},
            success: function(data) {
                var tot=parseFloat(data);
                var total=CurrencyFormat(tot,2);
                $('#total').html(total);
              
            },
        });
   });    
   $(".select-on-check-all").change(function(){
        var keys = $('#grid').yiiGridView('getSelectedRows');
        $("#op-requestids").val(keys.join());
   });
  
SCRIPT;
$this->registerJs($js);
?>

 <?php 
    $gridColumn = [
        [
            'class' => '\kartik\grid\SerialColumn',
            
         ],
         [
            'class' => '\kartik\grid\CheckboxColumn',
         ],
        [
          'attribute'=>'request_ref_num',
          'enableSorting' => false,
        ],
       
        [
            'attribute'=>'request_datetime',
            'pageSummary' => '<span style="float:right;">Total</span>',
            'enableSorting' => false,
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
        'containerOptions'=> ["style"  => 'overflow:auto;height:300px'],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        
        'responsive'=>false,
        'striped'=>true,
        'hover'=>true,
      
        'floatHeaderOptions' => ['scrollingTop' => true],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Request</h3>',
            'type'=>'primary',
          
            //
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
