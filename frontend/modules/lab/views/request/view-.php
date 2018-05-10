<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
//use kartik\widgets\DetailView;
//use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */

$this->title = $model->request_id;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <!-- <p>
        <?= Html::a('Update', ['update', 'id' => $model->request_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->request_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <div class="container">
        <div class="clearfix">
            <div style="float:left;">
               <!--  <?= DetailView::widget([
                    'model' => $model,
                    //'condensed'=>true,
                    //'hover'=>true,
                    //'mode'=>DetailView::MODE_VIEW,
                    // 'panel'=>[
                    //     'heading'=>'Book # ' . $model->request_id,
                    //     'type'=>DetailView::TYPE_INFO,
                    // ],
                    'attributes' => [
                        [
                            'attribute'=>'',
                            'label' => 'REQUEST DETAILS',
                            'format' => 'raw',
                            'value'=>'',
                            'contentOptions' => ['style'=>'background:none;border:none;'],
                            'captionOptions' => ['class' => 'text-primary','style'=>'background:none;border:none;'],
                        ],
                        'request_id',
                        'request_ref_num',
                        'request_datetime:datetime',
                        [
                            'attribute'=>'',
                            'label' => 'PAYMENT DETAILS',
                            'format' => 'raw',
                            'value'=>'',
                            'contentOptions' => ['style'=>'background:none;border:none;'],
                            'captionOptions' => ['class' => 'text-primary','style'=>'background:none;border:none;'],
                        ],
                        //'rstl_id',
                        //'lab_id',
                        //'customer_id',
                        //'payment_type_id',
                        //'modeofrelease_id',
                        //'discount',
                        //'discount_id',
                        //'purpose_id',
                        //'or_id',
                        'total',
                        'report_due',
                        'conforme',
                        'receivedBy',
                        //'created_at',
                        //'posted',
                        //'status_id',
                        [
                            'attribute'=>'',
                            'label' => 'TRANSACTION DETAILS',
                            'format' => 'raw',
                            'value'=>'',
                            'contentOptions' => ['style'=>'background:none;border:none;'],
                            'captionOptions' => ['class' => 'text-primary','style'=>'background:none;border:none;'],
                        ],
                    ],
                ]) ?> -->
            </div>
        </div>
    </div>

    <?php /*= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'request_id',
            'request_ref_num',
        ],
    ]);*/ ?>

</div>
