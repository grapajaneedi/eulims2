<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\finance\client */

$this->title = 'Create Client';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
