<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\services\Workflow */

$this->title = 'Create Workflow';
$this->params['breadcrumbs'][] = ['label' => 'Workflows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workflow-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
