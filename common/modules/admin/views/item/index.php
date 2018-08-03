<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\modules\admin\components\RouteRule;
use common\modules\admin\components\Configs;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('rbac-admin', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
$func=new Functions();
$Header="Department of Science and Technology<br>";
$Header.="User Role List";
?>
<div class="role-index">
<?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => $labels['Items']]); ?>
<?php
 echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="fa fa-users"></span>  ' . Html::encode($this->title),
            'before'=>Html::a(Yii::t('rbac-admin', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-success'])
        ],
        'exportConfig'=>$func->exportConfig("User Roles List", "user roles", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('rbac-admin', 'Name'),
            ],
            [
                'attribute' => 'ruleName',
                'label' => Yii::t('rbac-admin', 'Rule Name'),
                'filter' => $rules
            ],
            [
                'attribute' => 'description',
                'label' => Yii::t('rbac-admin', 'Description'),
                'format' => 'html',
                'noWrap' => false,
                'mergeHeader'=>true,
                'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                //'width'=>'120px'
            ],
        ],
    ])
?>
    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Back to Dashboard'), ['../site/login'], ['class' => 'btn btn-success',]) ?>
    </p>
     
</div>
