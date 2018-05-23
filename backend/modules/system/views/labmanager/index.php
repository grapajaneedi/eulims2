<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\LabManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lab Managers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lab-manager-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Lab Manager', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'lab_manager_id',
            'lab_id',
            'user_id',
            'active',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
