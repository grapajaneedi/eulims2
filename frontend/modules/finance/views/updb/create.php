<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\api\YiiMigration */

$this->title = 'Create Yii Migration';
$this->params['breadcrumbs'][] = ['label' => 'Yii Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yii-migration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
