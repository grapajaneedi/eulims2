<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use common\models\lab\Lab;
use yii\helpers\ArrayHelper;
use common\models\lab\LabManagerSearch;

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
        'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ],
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'class'=>'kartik\grid\CheckBoxColumn',
            ],
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
                    'pluginOptions' => ['allowClear' => true]
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
                'class'=>'kartik\grid\BooleanColumn',
                'attribute' => 'active',
                'label' => 'Active',
            ],
            [
            //'class' => 'yii\grid\ActionColumn'
            'class' => kartik\grid\ActionColumn::className(),
            'template' => $Buttontemplate,
            'buttons'=>[
              'view'=>function ($url, $model) {
                  return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::toRoute(['configurations/view','id'=>$model->lab_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Laboratory")]);
              },
              'update'=>function ($url, $model) {
                  return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::toRoute(['configurations/update','id'=>$model->lab_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Laboratory")]);
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
$SQL="SELECT `tbl_profile`.`user_id`,CONCAT(fnProperCase(`firstname`),' ',LEFT(UCASE(`middleinitial`),1) ,'. ',fnProperCase(`lastname`)) AS LabManager
FROM `tbl_profile` INNER JOIN `tbl_auth_assignment` ON(`tbl_auth_assignment`.`user_id`=`tbl_profile`.`user_id`)
WHERE `item_name`='lab-manager'";
$Connection= Yii::$app->db;
$Command=$Connection->createCommand($SQL);
$LabmanagerList=$Command->queryAll();
$searchModel = new LabManagerSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

$TechnicalManagerContent=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Lab Manager',
                'attribute'=>'user_id',
                'value' => function($model) {
                    return $model['labmanager'];
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map($LabmanagerList, 'user_id', 'LabManager'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'LabManager', 'user_id' => 'grid-products-search-category_type_id']
            ],
            [
                'attribute' => 'lab_id',
                'label' => 'Laboratory',
                'value' => function($data) {
                    return $data['labname'];
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Lab::find()->asArray()->all(), 'lab_id', 'labname'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Laboratory', 'lab_id' => 'grid-products-search-category_type_id']
            ],
            'updated_at:datetime',
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => $Buttontemplate,
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::toRoute(['labmanager/view','id'=>$model['user_id']]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Lab Manager")]);
                    },
                    'update'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::toRoute(['labmanager/update','id'=>$model['lab_id']]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Lab Manager")]);
                    }
                ],
               
            ],
        ],
    ]);
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
                        'content' => $TechnicalManagerContent,
                        'active' => false,
                        'options' => ['id' => 'manager_config'],
                       // 'visible' => Yii::$app->user->can('access-terminal-configurations')
                    ],
                    [
                        'label' => '<i class="fa-level-down"></i> Discounts',
                        'content' => "rtrttrtrtrtrtt",
                        'active' => false,
                        'options' => ['id' => 'discount_config'],
                       // 'visible' => Yii::$app->user->can('access-terminal-configurations')
                    ],
                ],
            ]);
    ?>
        </div>
    </div>
</div>
