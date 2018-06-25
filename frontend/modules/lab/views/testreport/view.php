<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\models\lab\Analysis;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testreport */

$this->title = $model->report_num;
$this->params['breadcrumbs'][] = ['label' => 'Testreports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testreport-view">
    <div class="form-row">
        <div class="container table-responsive">
            <button class="btn btn-warning pull-right"><i class="glyphicon glyphicon-check"></i> Reissue Report</button>
        </div>
    </div>
    <br>
    <div class="container table-responsive">
          <?= DetailView::widget([
            'model' => $model,
            'responsive'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
                'heading'=>'<i class="glyphicon glyphicon-book"></i> Test Report # ' . $model->report_num,
                'type'=>DetailView::TYPE_PRIMARY,
            ],
            'attributes' => [
                // 'testreport_id',
                // 'request_id',
                // 'lab_id',
                'report_num',
                'report_date',
                'status_id',
                'release_date',
                // 'reissue',
                // 'previous_id',
                // 'new_id',
                ],
            ]) ?>
    </div>
    <div class="form-row">
    <div class="container table-responsive">
        <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                // [
                //     'attribute'=>'sample_id',
                //     'enableSorting' => false,
                // ],
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
                        // // $transactions = $searchModel->searchbycustomerid($id);
                        //  $dprovider = $sModel->search(Yii::$app->request->queryParams);
                 
                         return $this->render('_testresults.php', [
                            //  'searchModel' => $sModel,
                            //  'dataProvider' => $dprovider,
                             'model'=>$analysisdataProvider,
                         ]);
                    },
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'expandOneOnly' => true
                ],


                [
                    'attribute'=>'sample.sample_code',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'sample.samplename',
                    'enableSorting' => false,
                ],
               
                    // 'headerOptions' => ['class' => 'kartik-sheet-style'],
                
            ];

            echo GridView::widget([
                'id' => 'sample-grid',
                'dataProvider'=> $trsamples,
                //'summary' => '',
                //'showPageSummary' => true,
                //'showHeader' => true,
                //'showPageSummary' => true,
                //'showFooter' => true,
                //'template' => '{update} {delete}',
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                //'filterModel' => $searchModel,
               // 'toggleDataOptions' => ['minCount' => 10],
                'panel' => [
                    'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i> Samples and Test Results</h3>',
                    'type'=>'primary',
                ],
                // 'rowOptions' => function ($model, $key, $index, $grid) {
                //     return [
                        //'id' => $model->sample_id,
                        // 'id' => $model->sample_id,
                        //'id' => $data['request_id'],
                        //'onclick' => 'alert(this.id);',
                        // 'onclick' => 'updateSample('.$model->sample_id.');',
                        // 'style' => 'cursor:pointer;',
                        //'onclick' => 'updateSample(this.id,this.request_id);',
                        // [
                        //     'data-id' => $model->sample_id,
                        //     'data-request_id' => $model->request_id
                        // ],
                //     ];
                // },
                'columns' => $gridColumns,
            
            ]);
        ?>
    </div>  
    </div>
    <div class="form-row">
        <div class="container table-responsive">
            <button class="btn btn-success">Print Function</button>
        </div>
    </div>
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

  

</div>
