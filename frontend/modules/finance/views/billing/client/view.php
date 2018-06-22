<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\client */

$this->title = $model->client_id;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'account_number',
                'label'=>'On Account #'
            ],
            'customer.customer_name',
            'customer.email',
            'company_name',
            [
                'attribute'=>'signature_date',
                'label'=>'Signature Date',
                'value'=>function($model){
                    return date('m/d/Y',strtotime($model->signature_date));
                }
            ],
            'signed:boolean',
            'active:boolean',
        ],
    ]) ?>
    <div class="row pull-right" style="padding-right: 15px">
        <button style='margin-left: 5px' type='button' class='btn btn-secondary pull-left-sm' data-dismiss='modal'>Cancel</button>
    </div>
</div>
