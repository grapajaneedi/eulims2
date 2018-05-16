<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use common\models\lab\Lab;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\LabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configurations';
$this->params['breadcrumbs'][] = ['label' => 'System', 'url' => ['/system']];
$this->params['breadcrumbs'][] = $this->title;

$Buttontemplate='{view}{update}'; 

$LaboratoryContent="<div class='row'><div class='col-md-12'>". GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-hover table-stripe table-hand'],
        'pjax'=>true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'labname',
                'label' => 'Laboratory Name',
                'value' => function($model) {
                    return $model->labname;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Lab::find()->asArray()->all(), 'labname', 'labname'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Lab Code', 'lab_id' => 'grid-products-search-category_type_id']
            ],
            [
                'attribute' => 'labcode',
                'label' => 'Lab Code',
                'value' => function($model) {
                    return $model->labcode;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Lab::find()->asArray()->all(), 'labcode', 'labcode'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Lab Code', 'lab_id' => 'grid-products-search-category_type_id']
            ],
            [
                'attribute' => 'labcount',
                'label' => 'Laboratory Count',
                'value' => function($model) {
                    return $model->labcount;
                }
            ],
            [
                'attribute' => 'nextrequestcode',
                'label' => 'Next Requestcode',
                'value' => function($model) {
                    return $model->nextrequestcode ? $model->nextrequestcode : '<No Request Code>';
                }
            ],
            [
            //'class' => 'yii\grid\ActionColumn'
            'class' => kartik\grid\ActionColumn::className(),
            'template' => $Buttontemplate,
            'buttons'=>[
              'view'=>function ($url, $model) {
                  return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::toRoute(['configurations/view','id'=>$model->lab_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View <font color='Blue'>Laboratory</font>")]);
              },
              'update'=>function ($url, $model) {
                  return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::toRoute(['configurations/update','id'=>$model->lab_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update <font color='Blue'>Laboratory</font>")]);
              }
                ],
            ],
        ],
    ])."</div></div>";
$createHTML=<<<HTML
    <p>
        <?= Html::a('Create Lab', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
HTML;
?>
<div class="lab-index">
    <div class="panel panel-primary">
        <div class="panel-heading">
        <div class="panel-title"></div>
        </div>
        <div class="panel-body">
    <?php
            echo TabsX::widget([
                'position' => TabsX::POS_ABOVE,
                'align' => TabsX::ALIGN_LEFT,
                'encodeLabels' => false,
                'id' => 'tab_system_config',
                'items' => [
                    [
                        'label' => '<i class="fa fa-columns"></i> Laboratories',
                        'content' => $LaboratoryContent,
                        'active' => true,
                        'options' => ['id' => 'laboratory_config'],
                       // 'visible' => Yii::$app->user->can('access-terminal-configurations')
                    ],
                    [
                        'label' => '<i class="fa fa-users"></i> Technical Managers',
                        'content' => "",
                        'active' => false,
                        'options' => ['id' => 'manager_config'],
                       // 'visible' => Yii::$app->user->can('access-terminal-configurations')
                    ],
                    [
                        'label' => '<i class="fa-level-down"></i> Discounts',
                        'content' => "",
                        'active' => false,
                        'options' => ['id' => 'manager_config'],
                       // 'visible' => Yii::$app->user->can('access-terminal-configurations')
                    ],
                ],
            ]);
    ?>
        </div>
    </div>
</div>
