<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SampleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Samples';
$this->params['breadcrumbs'][] = $this->title;
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
        
        <?= Html::button('Create Sample', ['value' => Url::to(['sample/create','request_id'=>1]),'title'=>'Create Sample', 'class' => 'btn btn-success','id' => 'modalBtn']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sample_id',
            //'rstl_id',
            //'pstcsample_id',
            //'package_id',
            //'sample_type_id',
            [
                'attribute' => 'sample_type_id',
                //'label' => 'Sample type',
                'format' => 'raw',
                //'value' => function($data) { return $data->sampleType->sample_type;},
                'value' => function($data){ return $data->sampleType->sample_type;},
            ],
            'sample_code',
            'samplename',
            'description:ntext',
            // 'sampling_date',
            // 'remarks',
            //'request_id',
            [
                'attribute' => 'request_id',
                //'label' => 'Request Code',
                'format' => 'raw',
                'value' => function($data){ return $data->request->request_ref_num;},
            ],
            // 'sample_month',
            // 'sample_year',
            // 'active',
            //['class' => 'yii\grid\ActionColumn'],
            [
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
            ],
        ],
    ]); ?>
        </div>
</div>
</div>

<script type="text/javascript">
//$.fn.modal.Constructor.prototype.enforceFocus = $.noop;
    $("#modalBtn").click(function(){
        $("#modalHeader").html($(this).attr('title'));
        $("#modal").modal('show')
        //$("#sampleModal").modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
</script>
