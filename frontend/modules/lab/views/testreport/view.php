<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testreport */

$this->title = $model->report_num;
$this->params['breadcrumbs'][] = ['label' => 'Testreports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testreport-view">
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
                    'heading'=>'<h3 class="panel-title">Samples</h3>',
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
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

  

</div>
