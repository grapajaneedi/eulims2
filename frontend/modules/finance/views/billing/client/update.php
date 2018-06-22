<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\client */

$this->title = 'Update Client: ' . $model->client_id;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_id, 'url' => ['view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
