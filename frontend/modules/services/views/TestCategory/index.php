<?php

use yii\helpers\Html;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;

use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\models\services\TestCategorySearch;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TestCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Test Category';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['/services']];
$this->params['breadcrumbs'][] = 'Manage Test Category';

$this->registerJsFile("/js/services/services.js");
$LabList= ArrayHelper::map(Lab::find()->all(),'lab_id','labname' );

if (Yii::$app->user->can('access-testcategory-delete')){
    $button='{view}{update}{delete}';
}else{
    $button='{view}{update}{delete}';
}
?>

<div class="test-category-index">
    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test Category', ['value'=>'/services/testcategory/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Test Category")]); ?>
      
    </p>
    <div class="table-responsive">

    <?php 
    $gridColumn = [
       // ['class' => '\kartik\grid\CheckboxColumn'],
        
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
         
                 return $this->render('view', [
                     'model'=>$model,
                 ]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
          'category_name',
            [
                'attribute' => 'lab_id',
                'label' => 'Laboratory',
                'value' => function($model) {
                    return $model->lab->labname;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $LabList,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Laboratory', 'lab_id' => 'grid-products-search-category_type_id']
            ],
          ['class' => 'kartik\grid\ActionColumn',
          'contentOptions' => ['style' => 'width: 8.7%'],
          'template' => $button,
          'buttons'=>[
              'view'=>function ($url, $model) {
                  return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/services/testcategory/view','id'=>$model->testcategory_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Test Category <font color='Blue'></font>")]);
              },
              'update'=>function ($url, $model) {
                  return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/services/testcategory/update','id'=>$model->testcategory_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Test Category<font color='Blue'></font>")]);
              },
          ],
      ],
    ]; 
    ?>
    <?= 
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
          'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
       'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
            ]) ,
        ],
    ]);
    
    // Html::a('Delete', ['delete', 'id' => $model->Package_DetailID], [
    //     'class' => 'btn btn-danger',
    //     'data' => [
    //         'confirm' => 'Are you sure you want to delete this item?',
    //         'method' => 'post',
    //     ],
    // ])  
    
    ?>
</div>

</div>
