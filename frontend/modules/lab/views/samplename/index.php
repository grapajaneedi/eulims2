<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\SampleNameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sample Name';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-name-index">
    <div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
            <div class="panel-body">
            <h1><?php //echo Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Sample Name', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'sample_name_id',
                    'sample_name',
                    //'description',
                    [
                        'attribute'=>'description',
                        'format' => 'raw',
                        //'enableSorting' => false,
                        'contentOptions' => [
                            'style'=>'max-width:40%; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
    </div>
</div>
