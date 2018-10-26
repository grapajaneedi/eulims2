<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Service', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'service_id',
            'agency_id',
            'method_ref_id',
            'offered_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
