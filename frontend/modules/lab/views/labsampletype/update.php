<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Labsampletype */

$this->title = 'Update Labsampletype: ' . $model->lab_sampletype_id;
$this->params['breadcrumbs'][] = ['label' => 'Labsampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->lab_sampletype_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="labsampletype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
