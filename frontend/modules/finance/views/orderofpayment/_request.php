<?php
use yii\helpers\Html;
use kartik\grid\GridView;



?>
<font style="font-weight:bold;font-size:0.9em">Select Request : </font>
<div class="row">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
       
        'pjax'=>true,
        'export'=>false,
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
   

         
        'columns' => [
            
            
            
            ['class' => 'yii\grid\SerialColumn'],
            'request_ref_num',
            'request_datetime',
           // 'orderofpayment_id',
           // 'rstl_id',
            'customer.customer_name',
        ],
    ]); ?>
</div>