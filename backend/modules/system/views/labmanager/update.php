<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\LabManager */

$this->title = 'Update Lab Manager: ' . $model->lab_manager_id;
$this->params['breadcrumbs'][] = ['label' => 'Lab Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lab_manager_id, 'url' => ['view', 'id' => $model->lab_manager_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lab-manager-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
