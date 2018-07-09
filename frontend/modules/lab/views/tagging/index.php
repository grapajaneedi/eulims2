<?php

use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaggingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Tagging';
$this->params['breadcrumbs'][] = ['label' => 'Tagging', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = 'Sample Tagging';

$this->registerJsFile("/js/services/services.js");


?>
<div class="tagging-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        // Html::a('Create Tagging', ['create'], ['class' => 'btn btn-success'])
         ?>
    </p>
    <div class="row">
             <div class="col-md-4">
                <?php $form = ActiveForm::begin(); ?>
                <?php
                        $disabled=false;
                        $func=new Functions();
                        echo $func->GetSampleCode($form,$model,$disabled,"Scan or Search Sample Code");
                ?>    
                <?php ActiveForm::end(); ?>
                </div>
                    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tagging_id',
            'user_id',
            'analysis_id',
            'start_date',
            'end_date',
            //'tagging_status_id',
            //'cancel_date',
            //'reason',
            //'cancelled_by',
            //'disposed_date',
            //'iso_accredited',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
