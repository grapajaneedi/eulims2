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

<?= 

GridView::widget([
        'dataProvider' => $analysisdataprovider,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  Analysis',
            ],
        'columns' => [
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
        
        ],
    ]); ?>
<?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'width' => '50px',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($model, $key, $index, $column) {
                        //query on analysis to get those records with sample_ids involve

                        $query = Analysis::find()->where(['sample_id'=>$model->sample_id]);
                        $analysisdataProvider = new ActiveDataProvider([
                            'query' => $query,
                        ]);
                 
                         return $this->render('_workflow.php', [
                             'model'=>$analysisdataProvider,
                         ]);
                    },
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'expandOneOnly' => true
                ],

                // [
                //     'attribute'=>'sample.sample_code',
                //     'enableSorting' => false,
                // ],
                // [
                //     'attribute'=>'sample.samplename',
                //     'enableSorting' => false,
                // ],        
            ];     
        ?>

<?php echo GridView::widget([
                'id' => 'sample-grid',
                'dataProvider'=> $sampleDataProvider,
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
                    'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i> Samples and Test Results</h3>',
                    'type'=>'primary',
                ],
                'columns' => $gridColumns,
            
            ]);

?>

