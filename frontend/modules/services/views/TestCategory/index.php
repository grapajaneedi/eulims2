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

//$this->title = 'Test Categories';
$this->title = 'Manage Test Category';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['/services']];
$this->params['breadcrumbs'][] = 'Manage Test Category';

// echo date('Y-m-d H:i:s');
// exit;

//$this->params['breadcrumbs'][] = 'Test Categories';
$this->registerJsFile("/js/services/services.js");
$LabList= ArrayHelper::map(Lab::find()->all(),'lab_id','labname' );//Yii::$app->user->identity->user_id

if (Yii::$app->user->can('access-testcategory-delete')){
    $button='{view}{update}{delete}';
}else{
    $button='{view}{update}{delete}';
}
?>

<div class="test-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test Category', ['value'=>'/services/testcategory/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Test Category")]); ?>
      
    </p>
    <div class="table-responsive">

    <?php
    // echo $searchmodel->testcategory->id;
    ?>

    <?php 
    $gridColumn = [
        ['class' => '\kartik\grid\CheckboxColumn'],
        
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                // $sModel = new TestCategorySearch();
                // // $transactions = $searchModel->searchbycustomerid($id);
                //  $dprovider = $sModel->search(Yii::$app->request->queryParams);
         
                 return $this->render('view', [
                    //  'searchModel' => $sModel,
                    //  'dataProvider' => $dprovider,
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
         //   ['class' => 'yii\grid\ActionColumn'],
          ['class' => 'kartik\grid\ActionColumn',
          'contentOptions' => ['style' => 'width: 8.7%'],
         // 'visible'=> Yii::$app->user->isGuest ? false : true,
          'template' => $button,
          'buttons'=>[
              'view'=>function ($url, $model) {
                  return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/services/testcategory/view','id'=>$model->test_category_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Test Category <font color='Blue'></font>")]);
              },
              'update'=>function ($url, $model) {
                  return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/services/testcategory/update','id'=>$model->test_category_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Test Category<font color='Blue'></font>")]);
              },
            //   'delete'=>function ($url, $model) {
            //     return Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value'=>Url::to(['/services/testcategory/delete','id'=>$model->test_category_id]), 'class' => 'btn btn-danger']);
            // },
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
