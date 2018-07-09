<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use common\models\system\Package;

/* @var $this yii\web\View */
/* @var $searchModel common\models\system\PackageDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => 'Modules', 'url' => ['/module']];
$this->params['breadcrumbs'][] = $this->title;
$Buttontemplate='{view}{update}';
?>
<div class="package-details-index">
     <div class="panel panel-primary col-xs-12">
        <div class="panel-heading"><i class="fa fa-angellist"></i> View <?= $this->title ?></div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <button onclick="LoadModal('Create Details','/module/details?action=create')" class="btn btn-success">Create Module Details</button>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'PackageID',
                'label' => 'Pagkage',
                'value' => function($model) {
                    return $model->package->PackageName;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Package::find()->asArray()->all(), 'PackageID', 'PackageName'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'PackageName', 'PackageID' => 'grid-products-search-category_type_id']
            ],
            'Package_Detail',
            'url',
            [
                'attribute' => 'icon',
                'label' => 'Icon',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->icon;
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', [
                                    'class' => 'btn btn-primary packageviewdetails',
                                    'title' => Yii::t('app', 'Package Details'),
                                    'value' => $url,
                                    'onclick' => 'LoadModal(this.title,this.value);'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', [
                                    'class' => 'btn btn-success packageviewdetails',
                                    'title' => Yii::t('app', 'Package Details'),
                                    'value' => $url,
                                    'onclick' => 'LoadModal(this.title,this.value);'
                        ]);
                    },
                ], 
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = '/module/details?action=view&id=' . $model->Package_DetailID;
                        return $url;
                    }
                    if ($action === 'update') {
                        $url = '/module/details?action=update&id=' . $model->Package_DetailID;
                        return $url;
                    }
                }
            ],
        ],
    ]);
    ?>
        </div>
     </div>
</div>
