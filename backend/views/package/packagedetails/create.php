<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\system\PackageDetails */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Package', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Details', 'url' => ['package/details']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-details-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
