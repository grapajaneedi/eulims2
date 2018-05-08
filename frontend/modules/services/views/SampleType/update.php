<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\services\Sampletype */

$this->title = 'Update Sampletype: ' . $model->sample_type_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sample_type_id, 'url' => ['view', 'id' => $model->sample_type_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sampletype-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
