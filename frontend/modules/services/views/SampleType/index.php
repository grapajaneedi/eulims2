<?php
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
use common\components\Functions;
//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\services\SampletypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sample Types';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['/services']];
$this->params['breadcrumbs'][] = 'Manage Sample Type';
$testcategorylist= ArrayHelper::map(testCategory::find()->all(),'testcategory_id','category_name');

//$this->params['breadcrumbs'][] = 'Test Categories';
$this->registerJsFile("/js/services/services.js");

$func=new Functions();
$Header="Department of Science and Technology<br>";
$Header.="List of Sample Types";

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
        'exportConfig'=>$func->exportConfig("Laboratory Request", "laboratory request", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'sample_type',
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

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
           // 'visible'=> Yii::$app->user->isGuest ? false : true,
            'template' => '{view}{update}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/services/sampletype/view?id='.$model->sample_type_id, 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Sample Type<font color='Blue'></font>")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/services/sampletype/update?id='.$model->sample_type_id,'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Sample Type<font color='Blue'></font>")]);
                },
            //     'delete'=>function ($url, $model) {
            //       $t = '/services/testcategory/delete';
            //      return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['value'=>'/services/sampletype/delete?id='.$model->sample_type_id, 'class' => 'btn btn-danger','title' => Yii::t('app', "View History for  <font color='Blue'></font>")]);
    
            //   },
            ],
        ],
        ],
    ]); ?>
</div>
