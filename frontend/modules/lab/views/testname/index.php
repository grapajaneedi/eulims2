<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\TestnameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Names';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testname-index">

<?php $this->registerJsFile("/js/services/services.js"); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test Name', ['value'=>'/services/testcategory/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Test Name")]); ?>
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
            'testName',
            [
                'attribute' => 'status_id',
                'label' => 'Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                    if ($model->status_id==1)
                    {   
                        return "<span class='badge badge-success' style='width:80px!important;height:20px!important;'>Active</span>";
                    }else{
                        return "<span class='badge badge-default' style='width:80px!important;height:20px!important;'>Inactive</span>";
                    }
                    
                },
            ],
            'create_time',
            'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
