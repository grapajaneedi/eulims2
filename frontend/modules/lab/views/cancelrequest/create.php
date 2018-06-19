<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Cancelledrequest */

$this->title = 'Create Cancelledrequest';
$this->params['breadcrumbs'][] = ['label' => 'Cancelledrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancelledrequest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
