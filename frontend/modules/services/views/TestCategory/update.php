<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\TestCategory */

$this->title = 'Update Test Category: ' . $model->test_category_id;
$this->params['breadcrumbs'][] = ['label' => 'Test Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->test_category_id, 'url' => ['view', 'id' => $model->test_category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="test-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
