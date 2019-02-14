<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\api\Migrationportal */

$this->title = 'Create Job';
$this->params['breadcrumbs'][] = ['label' => 'jobportal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobportal-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
