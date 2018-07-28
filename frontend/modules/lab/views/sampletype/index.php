<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Lab;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\SampletypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sample Types';
$this->params['breadcrumbs'][] = $this->title;

$lablist= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');
?>
<div class="sampletype-index">

<?php $this->registerJsFile("/js/services/services.js"); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Sample Type', ['value'=>'/services/testcategory/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Sample Type")]); ?>
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
            'type',
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
