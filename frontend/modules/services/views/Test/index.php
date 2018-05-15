<?php

use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\services\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tests';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['/services']];
$this->params['breadcrumbs'][] = 'Manage Test';

//$this->params['breadcrumbs'][] = 'Test Categories';
$this->registerJsFile("/js/services/services.js");
?>
<div class="test-index">

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test', ['value'=>'/services/test/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Test")]); ?>
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

            'test_id',
            'agency_id',
            'testname',
            'method',
            'references',
            // 'fee',
            // 'duration',
            // 'test_category_id',
            // 'sample_type_id',
            // 'lab_id',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
           // 'visible'=> Yii::$app->user->isGuest ? false : true,
            'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    $t = '/services/testcategory/create';
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/services/test/view?id='.$model->test_id, 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary modal_services','title' => Yii::t('app', "View Test<font color='Blue'></font>")]);
                },
                'update'=>function ($url, $model) {
                    $t = '/services/testcategory/create';
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/services/test/update?id='.$model->test_id,'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Update Test<font color='Blue'></font>")]);
                },
            //     'delete'=>function ($url, $model) {
            //       $t = '/services/testcategory/delete';
            //       return Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value'=>'/services/test/delete?id='.$model->test_id, 'class' => 'btn btn-danger modal_services','title' => Yii::t('app', "View History for  <font color='Blue'></font>")]);
    
            //   },
            ],
        ],
        ],
    ]); ?>
</div>
