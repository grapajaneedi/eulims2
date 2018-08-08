<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\feedback\UserFeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Feedbacks';

$this->params['breadcrumbs'][] = ['label' => 'Help', 'url' => ['/help']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-feedback-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Feedback', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'feedback_id',
            'url:ntext',
            'urlpath_screen:ntext',
            'details:ntext',
            'steps:ntext',
             'reported_by',
             'region_reported',
             'action_taken',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        </div>
</div>
</div>
