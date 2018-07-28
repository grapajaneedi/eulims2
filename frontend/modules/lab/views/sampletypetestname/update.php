<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sampletypetestname */

$this->title = 'Update Sampletypetestname: ' . $model->sampletype_testname_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletypetestnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sampletype_testname_id, 'url' => ['view', 'id' => $model->sampletype_testname_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sampletypetestname-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
