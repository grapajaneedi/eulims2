<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\api\YiiMigration */

$this->title = 'Update Yii Migration: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Yii Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="yii-migration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
