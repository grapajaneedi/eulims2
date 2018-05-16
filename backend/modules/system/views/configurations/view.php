<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Lab */

$this->title = $model->lab_id;
$this->params['breadcrumbs'][] = ['label' => 'Labs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lab-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'lab_id',
            'labname',
            'labcode',
            'labcount',
            'nextrequestcode',
            'active',
            [
                'class'=>'kartik\checkbox\CheckboxX',
                'attribute' => 'active',
            ]
        ],
    ]) ?>
    <div style="position:absolute;right:18px;bottom:10px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
</div>
