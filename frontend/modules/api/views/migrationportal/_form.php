<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\api\Migrationportal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobportal-form">

    <?php $form = ActiveForm::begin(); ?> 

    <?= $form->field($model, 'rstl_id')->textInput(['value'=>Yii::$app->user->identity->profile->rstl_id]) ?>

    <?= $form->field($model, 'region_initial')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
