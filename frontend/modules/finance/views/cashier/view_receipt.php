<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use common\models\finance\Collection;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Op */

$this->title = 'Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Cashier', 'url' => ['/finance/cashier']];
$this->params['breadcrumbs'][] = ['label' => 'Receipt', 'url' => ['/finance/cashier/receipt']];
$this->params['breadcrumbs'][] = 'View';

?>
<div class="receipt-view">

   <div class="container">
    <?= DetailView::widget([
        'model'=>$model,
        'responsive'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<i class="glyphicon glyphicon-book"></i> Receipt#: ' . $model->or_number,
            'type'=>DetailView::TYPE_PRIMARY,
         ],
        'buttons1' => '',
        'attributes' => [
            [
                'columns' => [
                    [
                        'label'=>'Payor',
                        'format'=>'raw',
                        'value'=>$model->payor,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Nature of Collection',
                        'format'=>'raw',
                        'value'=>$model->collectiontype->natureofcollection,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
            [
                'columns' => [
                    [
                        'label'=>'Receipt Date',
                        'format'=>'raw',
                        'value'=>$model->receiptDate,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Total of Collection',
                        'format'=>'raw',
                        'value'=>$model->total,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
          
        ],
    ]) ?>
   </div>
    <div class="main-container">
        <div class="container">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                //['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'sample_code',
                    'enableSorting' => false,
                    'contentOptions' => [
                        'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'attribute'=>'samplename',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'description',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($data){
                        return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".$data->sampling_date."</b></span>,&nbsp;".$data->description : $data->description;
                    },
                   'contentOptions' => [
                        'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{delete}',
                    'dropdown' => false,
                    'dropdownOptions' => ['class' => 'pull-right'],
                    //'urlCreator' => function($action, $model, $key, $index) { return '#'; },
                    'urlCreator' => function ($action, $model, $key, $index) {
                        /*if ($action === 'update') {
                            $url ='index.php?r=client-login/lead-update&id='.$model->id;
                            return $url;
                        }*/
                        if ($action === 'delete') {
                            $url ='/lab/sample/delete?id='.$model->sample_id;
                            return $url;
                        }

                    },
                    /*'viewOptions' => ['title' => 'This will launch the book details page. Disabled for this demo!', 'data-toggle' => 'tooltip'],
                    'updateOptions' => ['title' => 'This will launch the book update page. Disabled for this demo!', 'data-toggle' => 'tooltip'],*/
                    'deleteOptions' => ['title' => 'Delete Sample', 'data-toggle' => 'tooltip'],
                    //'buttons' => [
                        /*'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'lead-view'),
                            ]);
                        },

                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'lead-update'),
                            ]);
                        },*/
                        /*'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                        }*/

                    //],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                ],
            ];

            echo GridView::widget([
                'id' => 'sample-grid',
                'dataProvider'=> $sampleDataProvider,
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
                    //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['/lab/sample/create','request_id'=>$model->request_id], ['class' => 'btn btn-success']),
                    'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['disabled'=>$enableRequest, 'value' => Url::to(['sample/create','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
                    ////.Html::button('<i class="glyphicon glyphicon-plus"></i> Generate Samplecode', ['value' => Url::to(['sample/generatesamplecode','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
                    //'after'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['value' => Url::to(['sample/create','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
                    //'after'=>'',
                    'after'=>false,
                    //'footer'=>false,
                ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return [
                        //'id' => $model->sample_id,
                        'id' => $model->sample_id,
                        //'id' => $data['request_id'],
                        //'onclick' => 'alert(this.id);',
                        'onclick' => 'updateSample('.$model->sample_id.');',
                        'style' => 'cursor:pointer;',
                        //'onclick' => 'updateSample(this.id,this.request_id);',
                        // [
                        //     'data-id' => $model->sample_id,
                        //     'data-request_id' => $model->request_id
                        // ],
                    ];
                },
                'columns' => $gridColumns,
                'toolbar' => [
                    'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i>', [Url::to(['request/view','id'=>$model->request_id])], [
                                'class' => 'btn btn-default', 
                                'title' => 'Reset Grid'
                            ]),
                    '{toggleData}',
                ],
            ]);
        ?>
        </div>
    </div>
    </div>
</div>
