<?php
use yii\helpers\Html;
use kartik\grid\GridView;



?>
<font style="font-weight:bold;font-size:0.9em">Select Request : </font>
<div class="row">
 <?php 
    $gridColumn = [
         /*[
            'class' => '\kartik\grid\SerialColumn',
            
         ],
         [
            'class' => '\kartik\grid\CheckboxColumn',
           
         ],*/
        'request_ref_num',
        'request_datetime',
        'customer.customer_name',
    ];
?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax'=>false,
        'export'=>false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
         ],
         'columns' =>$gridColumn,
    ]); ?>
</div>
<script type="text/javascript">
  //  $.pjax.reload({container: "#w0", timeout: false});  
</script>
