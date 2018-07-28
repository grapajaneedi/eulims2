<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\SampletypetestnameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sample Type Testnames';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sampletypetestname-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sample Type Testname', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sampletype_testname_id',
            'sampletype_id',
            'testname_id',
            'added_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
