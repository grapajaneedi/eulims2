<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testreport */
$mydata=$model->testreports;
$this->title = $model->request->request_ref_num;
$this->params['breadcrumbs'][] = ['label' => 'Batch Testreports', 'url' => ['index']];
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
                'heading'=>'<i class="glyphicon glyphicon-book"></i> Request # ' . $model->request->request_ref_num,
                'type'=>DetailView::TYPE_PRIMARY,
            ],	
            'attributes' => [
            	[
            		'label'=>'Request Ref. Number',
            		'attribute'=>'request_id',
                	'value'=>$model->request->request_ref_num
            	],
            	[
            		'label'=>'Request Date / Time',
            		'attribute'=>'request_id',
                	'value'=>date('m-d-Y / H:i A',strtotime($model->request->request_datetime))
            	],
            	[
            		'label'=>'Request Due',
            		'attribute'=>'request_id',
                	'value'=>date('m-d-Y / H:i A',strtotime($model->request->report_due))
            	],
            	[
            		'label'=>'Customer',
            		'attribute'=>'request_id',
                	'value'=>$model->request->customer->customer_name
            	],
            	[
            		'label'=>'Fax',
            		'attribute'=>'request_id',
                	'value'=>$model->request->customer->fax
            	],
            	[
            		'label'=>'Telephone',
            		'attribute'=>'request_id',
                	'value'=>$model->request->customer->tel
            	],
            	[
            		'label'=>'Complete Address',
            		'attribute'=>'request_id',
                	'value'=>$model->request->customer->completeaddress
            	],
                ],
            ]) ?>
    </div>
    <div class="form-row">
    <div class="container table-responsive">
        <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'testreport_id',
                'report_num',
             //    [
            	// 	'header'=>'Test Report Number',
            	// 	'attribute'=>'request_id',
             //    	'value'=>$mydata->testreportSamples[0]->sample_id
            	// ],
                // [
                //     'attributec'=>'sample_id',
                //     'enableSorting' => false,
                // ],
                // [
                //     'class' => 'kartik\grid\ExpandRowColumn',
                //     'width' => '50px',
                //     'value' => function ($model, $key, $index, $column) {
                //         return GridView::ROW_COLLAPSED;
                //     },
                //     'detail' => function ($model, $key, $index, $column) {
                //         //query on analysis to get those records with sample_ids involve

                //         $query = Analysis::find()->where(['sample_id'=>$model->sample_id]);
                //         $analysisdataProvider = new ActiveDataProvider([
                //             'query' => $query,
                //         ]);
                //         // // $transactions = $searchModel->searchbycustomerid($id);
                //         //  $dprovider = $sModel->search(Yii::$app->request->queryParams);
                 
                //          return $this->render('_testresults.php', [
                //             //  'searchModel' => $sModel,
                //             //  'dataProvider' => $dprovider,
                //              'model'=>$analysisdataProvider,
                //          ]);
                //     },
                //     'headerOptions' => ['class' => 'kartik-sheet-style'],
                //     'expandOneOnly' => true
                // ],
                //samplecode
                //sample name
                //reportnumber
             //    [
            	// 	'header'=>'Test Report Number',
            	// 	'attribute'=>'request_id',
             //    	'value'=>$model->testreport->report_num
            	// ],
            	// [
            	// 	'header'=>'Sample Name',
            	// 	'attribute'=>'request_id',
             //    	'value'=>$model->testreport->request->sample->samplename
            	// ],
            	// [
            	// 	'header'=>'Sample Code',
            	// 	'attribute'=>'request_id',
             //    	'value'=>$model->testreport->request->sample->samplecode
            	// ],
                    // 'headerOptions' => ['class' => 'kartik-sheet-style'],
            ];

            echo GridView::widget([
                'id' => 'sample-grid',
                'dataProvider'=> $mydata,
                //'summary' => '',
                //'showPageSummary' => true,
                //'showHeader' => true,
                //'showPageSummary' => true,
                //'showFooter' => true,
                //'template' => '{update} {delete}',
                // 'pjax'=>true,
                // 'pjaxSettings' => [
                //     'options' => [
                //         'enablePushState' => false,
                //     ]
                // ],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                //'filterModel' => $searchModel,
               // 'toggleDataOptions' => ['minCount' => 10],
                'panel' => [
                    'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i>Test Results with Sample</h3>',
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
