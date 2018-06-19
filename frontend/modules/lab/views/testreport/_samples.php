 <?php 
use kartik\grid\GridView;
use yii\helpers\Html;


    $gridColumn = [
        [
          'class' => '\kartik\grid\CheckboxColumn',
        ],
        [
          'class' => '\kartik\grid\SerialColumn',    
        ],
        [
          'attribute'=>'sample_code',
          'enableSorting' => false,
        ],
        [
          'attribute'=>'samplename',
          'enableSorting' => false,
        ],
        [
          'attribute'=>'description',
          'enableSorting' => false,
        ],
        [
          'attribute'=>'remarks',
          'enableSorting' => false,
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
         ],
       
         'columns' =>$gridColumn,
         'showPageSummary' => true,
         /*'afterFooter'=>[
             'columns'=>[
                 'content'=>'Total Selected'
             ],
             
         ],*/
    ]); ?>