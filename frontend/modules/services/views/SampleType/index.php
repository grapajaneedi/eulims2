<?php
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\services\SampletypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sample Types';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['/services']];
$this->params['breadcrumbs'][] = 'Manage Sample Type';
$testcategorylist= ArrayHelper::map(testCategory::find()->all(),'test_category_id','category_name');

//$this->params['breadcrumbs'][] = 'Test Categories';
$this->registerJsFile("/js/services/services.js");
?>
<div class="sampletype-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Sample Type', ['value'=>'/services/sampletype/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Sample Type")]); ?>
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
            'sample_type',
            [
                'attribute' => 'test_category_id',
                'label' => 'Test Category',
                'value' => function($model) {
                    return $model->testCategory->category_name;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $testcategorylist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Test Category', 'test_category_id' => 'grid-products-search-category_type_id']
            ],

            ['class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
           // 'visible'=> Yii::$app->user->isGuest ? false : true,
            'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    $t = '/services/testcategory/create';
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/services/sampletype/view?id='.$model->sample_type_id, 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary modal_services','title' => Yii::t('app', "View Sample Type<font color='Blue'></font>")]);
                },
                'update'=>function ($url, $model) {
                    $t = '/services/testcategory/create';
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/services/sampletype/update?id='.$model->sample_type_id,'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Update Sample Type<font color='Blue'></font>")]);
                },
                'delete'=>function ($url, $model) {
                  $t = '/services/testcategory/delete';
                  return Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value'=>'/services/sampletype/delete?id='.$model->sample_type_id, 'class' => 'btn btn-danger modal_services','title' => Yii::t('app', "View History for  <font color='Blue'></font>")]);
    
              },
            ],
        ],
        ],
    ]); ?>
</div>
