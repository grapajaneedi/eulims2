<?php
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\services\Testcategory;
use common\models\services\Sampletype;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PackagelistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Package';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['/services']];
$this->params['breadcrumbs'][] = 'Manage Package';
$testcategorylist= ArrayHelper::map(testCategory::find()->all(),'testcategory_id','category_name');
$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sample_type_id','sample_type');

//$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile("/js/services/services.js");
?>
<div class="packagelist-index">

 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Package', ['value'=>'/services/packagelist/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Package")]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'package_id',
            [
                'attribute' => 'testcategory_id',
                'label' => 'Test Category',
                'value' => function($model) {
                    return $model->testcategory->category_name;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $testcategorylist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Test Category', 'testcategory_id' => 'grid-products-search-category_type_id']
            ],
              [
                'attribute' => 'sample_type_id',
                'label' => 'Sample Type',
                'value' => function($model) {
                    return $model->sampletype->sample_type;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $sampletypelist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Sample Type', 'sample_type_id' => 'grid-products-search-category_type_id']
            ],
            'name',
            //'rate',
            //'tests',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
           // 'visible'=> Yii::$app->user->isGuest ? false : true,
            'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/services/packagelist/view?id='.$model->package_id, 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Package<font color='Blue'></font>")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/services/packagelist/update?id='.$model->package_id,'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Package<font color='Blue'></font>")]);
                },
            //     'delete'=>function ($url, $model) {
            //       $t = '/services/testcategory/delete';
            //     //  return Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value'=>'/services/sampletype/delete?id='.$model->sample_type_id, 'class' => 'btn btn-danger','title' => Yii::t('app', "View History for  <font color='Blue'></font>")]);
    
            //   },
            ],
        ],
        ],
    ]); ?>
</div>
