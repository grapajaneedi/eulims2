<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\TestCategory */

$this->title = 'Update Test Category: ' . $model->testcategory_id;
$this->params['breadcrumbs'][] = ['label' => 'Test Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->testcategory_id, 'url' => ['view', 'id' => $model->testcategory_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="test-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
