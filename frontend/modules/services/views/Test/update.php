<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\services\Test */

$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->test_id, 'url' => ['view', 'id' => $model->test_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="test-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
