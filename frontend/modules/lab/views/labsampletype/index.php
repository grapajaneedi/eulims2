<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Lab;
use common\models\lab\Sampletype;
use yii\helpers\ArrayHelper;


$lablist= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');
$sampetypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\LabsampletypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lab Sample Type';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="labsampletype-index">

    <?php $this->registerJsFile("/js/services/services.js"); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Lab Sample Type', ['value'=>'/lab/labsampletype/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Lab Sample Type")]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'lab_id',
                'label' => 'Lab',
                'value' => function($model) {
                    return $model->lab->labname;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $lablist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
               ],
               'filterInputOptions' => ['placeholder' => 'Lab', 'testcategory_id' => 'grid-products-search-category_type_id']
            ],
            [
                'attribute' => 'sampletypeId',
                'label' => 'Sample Type',
                'value' => function($model) {
                    return $model->sampletype->type;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $sampetypelist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
               ],
               'filterInputOptions' => ['placeholder' => 'Sample Type', 'testcategory_id' => 'grid-products-search-category_type_id']
            ],
            'effective_date',
            'added_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
