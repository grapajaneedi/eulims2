<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\services\Workflow */

$this->title = 'Update Workflow: ' . $model->workflow_id;
$this->params['breadcrumbs'][] = ['label' => 'Workflows', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->workflow_id, 'url' => ['view', 'id' => $model->workflow_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="workflow-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
