<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\TestreportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testreport-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create New Test Report', ['value'=>'/lab/testreport/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create New Test Report"),'name'=>'Create New Test Report']); ?>
    </p>

    <div class="table-responsive">
        
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel'=>[
                'type'=>Gridview::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'testreport_id',
            'request_id',
            'lab_id',
            'report_num',
            'report_date',
            //'status_id',
            //'release_date',
            //'reissue',
            //'previous_id',
            //'new_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div>
