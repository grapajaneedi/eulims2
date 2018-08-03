<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignment');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'kartik\grid\SerialColumn'],
    $usernameField,
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view}'
];
$func=new Functions();
$Header="Department of Science and Technology<br>";
$Header.="User Assignment List";
?>
<div class="assignment-index">
    <?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => 'assignment']); ?>
    <?=
    GridView::widget([
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
            'before'=>Html::a(Yii::t('rbac-admin', 'Signup New User'), ['signup'], ['class' => 'btn btn-success',])
        ],
        'exportConfig'=>$func->exportConfig("User Assignment List", "user assignment", $Header),
        'columns' => $columns,
    ]);
    ?>
    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Back to Dashboard'), ['../site/login'], ['class' => 'btn btn-success',]) ?>
    </p>
</div>
