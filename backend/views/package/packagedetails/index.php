<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use common\models\system\Package;

/* @var $this yii\web\View */
/* @var $searchModel common\models\system\PackageDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => 'Package', 'url' => ['/package']];
$this->params['breadcrumbs'][] = $this->title;
$Buttontemplate='{view}{update}';
?>
<div class="package-details-index">
     <div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-angellist"></i> View <?= $this->title ?></div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <button onclick="LoadModal('Create Details','/package/details?action=create')" class="btn btn-success">Create Package Details</button>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                    return "<span class='" . $model->icon . "'><span>";
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
             [
                        //'class' => 'yii\grid\ActionColumn'
                        'class' => ActionColumn::className(),
                        'template'=>$Buttontemplate,'class' => 'yii\grid\ActionColumn',
                        'header' => 'Actions',
                        'headerOptions' => ['style' => 'color:#337ab7'],
                        'template' => '{view}{update}{delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                //return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                //    'title' => Yii::t('app', 'lead-view'),
                                //]);
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', [
                                    'class'=>'btn btn-primary packageviewdetails',
                                    'title' => Yii::t('app', 'Package Details'),
                                    'value'=>$url,
                                    'onclick'=>'LoadModal(this.title,this.value);'
                                ]);
                            },
                            'update' => function ($url, $model) {
                                //return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                //    'title' => Yii::t('app', 'lead-update'),
                                //]);
                                return Html::button('<span class="glyphicon glyphicon-pencil"></span>', [
                                    'class'=>'btn btn-primary packageviewdetails',
                                    'title' => Yii::t('app', 'Package Details'),
                                    'value'=>$url,
                                    'onclick'=>'LoadModal(this.title,this.value);'
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-delete'),
                                    'class'=>'btn btn-primary'
                                ]);
                            }
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url ='/package/details?action=view&id='.$model->Package_DetailID;
                                return $url;
                            }
                            if ($action === 'update') {
                                //$url ='index.php?r=client-login/lead-update&id='.$model->Package_DetailID;
                                $url ='/package/details?action=update&id='.$model->Package_DetailID;
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url ='/package/deletedetails/'.$model->Package_DetailID;
                                return $url;
                            }
                        }
                    ],
        ],
    ]); ?>
        </div>
     </div>
</div>
