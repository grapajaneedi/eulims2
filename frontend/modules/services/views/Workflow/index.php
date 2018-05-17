<?php


use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\services\Test;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WorkflowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Workflow Management';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("/js/services/services.js");

$testlist= ArrayHelper::map(Test::find()->all(),'test_id','testname');
?>
<div class="workflow-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create New Workflow', ['value'=>'/services/workflow/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Workflow")]); ?>
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

            'workflow_id',
            // [
            //     'attribute' => 'test_category_id',
            //     'label' => 'Test Category',
            //     'value' => function($model) {
            //         return $model->tests->testname;
            //     },
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filter' => $testlist,
            //     'filterWidgetOptions' => [
            //         'pluginOptions' => ['allowClear' => true],
            //     ],
            //     'filterInputOptions' => ['placeholder' => 'Test Category', 'test_category_id' => 'grid-products-search-category_type_id']
            // ],

            'method',
            'workflow',
            // ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
           // 'visible'=> Yii::$app->user->isGuest ? false : true,
            // 'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/services/workflow/view?id='.$model->workflow_id, 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Workflow<font color='Blue'></font>")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/services/workflow/update?id='.$model->workflow_id,'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Workflow<font color='Blue'></font>")]);
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
