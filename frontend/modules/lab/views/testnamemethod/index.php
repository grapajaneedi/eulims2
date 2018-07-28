<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Methodreference;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\TestnamemethodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$methodlist= ArrayHelper::map(Methodreference::find()->all(),'method_reference_id','method');
$testnamelist= ArrayHelper::map(Testname::find()->all(),'testname_id','testName');

$this->title = 'Test Name Methods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testnamemethod-index">

<?php $this->registerJsFile("/js/services/services.js"); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test Name Method', ['value'=>'/services/testcategory/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Test Name Method")]); ?>
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
                'attribute' => 'testname_id',
                'label' => 'Test Name',
                'value' => function($model) {
                    return $model->testname->testName;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $testnamelist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
               ],
               'filterInputOptions' => ['placeholder' => 'Test Name', 'testcategory_id' => 'grid-products-search-category_type_id']
            ],
            [
                'attribute' => 'method_id',
                'label' => 'Method',
                'value' => function($model) {
                    return $model->method->method;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $methodlist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
               ],
               'filterInputOptions' => ['placeholder' => 'Method', 'testcategory_id' => 'grid-products-search-category_type_id']
            ],
            'create_time',
            'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
