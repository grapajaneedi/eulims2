<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SampleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Samples';
$this->params['breadcrumbs'][] = ['label' => 'Lab', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
?>
<?php
/*Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'sampleModal',
    'size' => 'modal-lg',
    //'tabindex' => false
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'>This is a sample</div>";
Modal::end();*/
?>
<div class="sample-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //= Html::a('Create Sample', ['create'], ['class' => 'btn btn-success']) ?>
        <?php //= Html::button('Create Sample', ['onClick'=>"LoadModal('Create Sample',array('/lab/sample/create','id'))", 'class' => 'btn btn-success','id' => 'modalButton']) ?>
        
        <?php //echo Html::button('Create Sample', ['value' => Url::to(['sample/create','request_id'=>1]),'title'=>'Create Sample', 'class' => 'btn btn-success','id' => 'modalBtn']); ?>
    </p>
        <fieldset>
        <legend>Legend/Status</legend>
        <div style='padding: 0 10px'>
			<span class='badge btn-success legend-font'><span class='glyphicon glyphicon-ok'></span> ACTIVE</span>
            <span class='badge btn-danger legend-font'><span class='glyphicon glyphicon-ban-circle'></span> CANCELLED</span>
        </div>
		</fieldset>

    <?= GridView::widget([
		'id' => 'sample-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
		'panel' => [
			'heading'=>'<h3 class="panel-title">Samples</h3>',
			'type'=>'primary',
			//'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['disabled'=>$enableRequest, 'value' => Url::to(['sample/create','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn'])." ".Html::button('<i class="glyphicon glyphicon-print"></i> Print Label', ['disabled'=>!$enableRequest, 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/reports/preview?url=/lab/request/printlabel','request_id'=>$model->request_id]) . "';" ,'title'=>'Print Label',  'class' => 'btn btn-success']),
			'after'=>false,
		],
		//'headerOptions' => ['class' => 'kartik-sheet-style'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'sample_id',
            //'rstl_id',
            //'pstcsample_id',
            //'package_id',
            //'sample_type_id',
            [
                'attribute' => 'request_id',
                //'label' => 'Request Code',
                'format' => 'raw',
                'value' => function($data){ return $data->request->request_ref_num;},
                'group'=>true,  // enable grouping
				'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'sample_type_id',
                //'label' => 'Sample type',
                'format' => 'raw',
                //'value' => function($data) { return $data->sampleType->sample_type;},
                'value' => function($data){ return $data->sampleType->sample_type;},
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $sampletypes,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Sample Type', 'id' => 'grid-op-search-sample_type_id'],
				'headerOptions' => ['class' => 'text-center'],
            ],
            [
				'attribute'=>'sample_code',
				'headerOptions' => ['class' => 'text-center'],
			],
			[
				'attribute'=>'samplename',
				'headerOptions' => ['class' => 'text-center'],
			],
            [
                'attribute'=>'description',
                'format' => 'raw',
                //'enableSorting' => false,
                'contentOptions' => [
                    'style'=>'max-width:40%; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
				'headerOptions' => ['class' => 'text-center'],
            ],
			[
                'attribute'=>'active',
				'header' => 'Status',
                'format' => 'raw',
				'value' => function($data){ return ($data->active == 1) ? "<span class='badge btn-success legend-font'>ACTIVE</span>" : "<span class='badge btn-danger legend-font'>CANCELLED</span>";},
                //'enableSorting' => false,
				'filterType' => GridView::FILTER_SELECT2,
                'filter' => ['1' => 'Active', '0' => 'Cancelled'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Status', 'id' => 'grid-op-search-active'],
				'contentOptions' => ['class' => 'text-center'],
				'headerOptions' => ['class' => 'text-center'],
            ],
            // 'sampling_date',
            // 'remarks',
            //'request_id',
            // 'sample_month',
            // 'sample_year',
            // 'active',
            //['class' => 'yii\grid\ActionColumn'],
            /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                            if (Yii::$app->user->identity->id != $model->sample_id) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['/lab/sample/update', 'id' => $model->sample_id,'request_id'=>$model->request_id]),
                                    [
                                        'title' => Yii::t('app', 'Update'),
                                        'data-pjax' => '0',
                                        'aria-label' => 'Update',
                                        'class' => 'btn btn-primary'
                                    ]
                                );
                            }
                        },
                ],
            ],*/
        ],
		'toolbar' => [
			'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', [Url::to([''])], [
						'class' => 'btn btn-default', 
						'title' => 'Reset Grid'
					]),
			//'{toggleData}',
		],
		
    ]); ?>
        </div>
</div>
</div>

<script type="text/javascript">
//$.fn.modal.Constructor.prototype.enforceFocus = $.noop;
    $("#modalBtn").click(function(){
        $(".modal-title").html($(this).attr('title'));
        $("#modal").modal('show')
        //$("#sampleModal").modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
</script>
