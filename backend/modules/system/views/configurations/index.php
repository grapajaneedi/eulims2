<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\LabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configurations';
$this->params['breadcrumbs'][] = ['label' => 'System', 'url' => ['/system']];
$this->params['breadcrumbs'][] = $this->title;

$LaboratoryContent="<div class='row'><div class='col-md-12'>". GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => ['options' => ['class'=> 'table table-hover table-stripe']],
        'pjax'=>true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'labname',
                'label' => 'Laboratory Name',
                'value' => function($model) {
                    return $model->labname;
                }
            ],
            [
                'attribute' => 'labcode',
                'label' => 'Lab Code',
                'value' => function($model) {
                    return $model->labcode;
                }
            ],
            'labcount',
            'nextrequestcode',
            // 'active',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ])."</div></div>";
$create=<<<HTML
    <p>
        <?= Html::a('Create Lab', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
HTML;
?>
<div class="lab-index">
    <div class="panel panel-default">
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
