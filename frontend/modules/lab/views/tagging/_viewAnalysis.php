<?php

use yii\helpers\Html;
use kartik\widgets\DatePicker;
use common\models\lab\Tagging;
use common\models\lab\Analysis;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
use common\components\Functions;
use yii\data\ActiveDataProvider;

?>

<div id="divSpinner" style="text-align:center;display:none;font-size:30px">
     <div class="animationload">
            <div class="osahanloading"></div>
     </div>
</div>

<?= GridView::widget([
        'dataProvider' => $sampleDataProvider,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  Sample' ,
            ],
        'columns' => [
            [
                'header'=>'Sample Name',
                'format' => 'raw',
                'enableSorting' => false,
                'attribute'=>'samplename',
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'], 
            ],
            [
                'header'=>'Description',
                'format' => 'raw',
                'enableSorting' => false,
                'attribute'=>'description',
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],   
            ],
            
        ],
    ]); ?>
<script type='text/javascript'>


setTimeout(function(){
    ShowProgressSpinner(false);
},1000);

 
</script>

<?php

//$doc = new DomDocument;

// We need to validate our document before refering to the id
// $doc->validateOnParse = true;
// $doc->loadHtml(file_get_contents('index.php'));

// $test= $doc->getElementById('divSpinner');
// $test->setAttribute('style','display:none');
?>


 <?php
            $gridColumns = [
              //  ['class' => 'yii\grid\SerialColumn'],
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
             
                     return $this->render('_workflow', [
                         'model'=>$model,
                     ]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
                    [
                        'header'=>'Test Name',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->testname;
                        },
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                       
                    ],
                    [
                        'header'=>'Method',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->method;
                        },
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                       
                    ],
                    [
                        'header'=>'Analyst',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                       
                    ],
                    [
                        'header'=>'Status',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                       
                    ],
                    [
                        'header'=>'Remarks',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                ],
                
                
            ];     
        ?>

<?php echo GridView::widget([
                'id' => 'analysis-grid',
                'dataProvider'=> $analysisdataprovider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
               // 'responsive'=>true,
                'striped'=>true,
               // 'hover'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i>Analysis</h3>',
                    'type'=>'primary',
                ],
                'columns' => $gridColumns,       
            ]);



            ///////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php 
    $gridColumn = [
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
         
                 return $this->render('_workflow', [
                     'model'=>$model,
                 ]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
         
    ]; 
    ?>
    <?= 
    GridView::widget([
        'dataProvider' => $analysisdataprovider,
       // 'filterModel' => $searchModel,
          'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
       'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $analysisdataprovider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
            ]) ,
        ],
    ]);
    
    // Html::a('Delete', ['delete', 'id' => $model->Package_DetailID], [
    //     'class' => 'btn btn-danger',
    //     'data' => [
    //         'confirm' => 'Are you sure you want to delete this item?',
    //         'method' => 'post',
    //     ],
    // ])  
    
    ?>
