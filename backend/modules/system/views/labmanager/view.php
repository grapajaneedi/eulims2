<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\LabManager */

$this->title = $model->lab_manager_id;
$this->params['breadcrumbs'][] = ['label' => 'Lab Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lab-manager-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->lab_manager_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->lab_manager_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'lab_manager_id',
            'lab_id',
            'user_id',
            'active',
            'updated_at',
        ],
    ]) ?>

</div>
