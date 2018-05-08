<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\services\Test */

$this->title = 'Create Test';
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-create">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
