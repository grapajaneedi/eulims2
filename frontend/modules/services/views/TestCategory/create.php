<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\TestCategory */

//$this->title = 'Create Test Category';
$this->params['breadcrumbs'][] = ['label' => 'Test Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
