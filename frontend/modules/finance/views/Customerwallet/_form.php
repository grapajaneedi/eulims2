<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\lab\Customer;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Customerwallet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customerwallet-form">

    <?php  $form = ActiveForm::begin(); ?>

    <?php 
	// Normal select with ActiveForm & model
	echo $form->field($model, 'customer_id')->widget(Select2::classname(), [
    	'data' => ArrayHelper::map(Customer::find()->all(), 'customer_id', 'customer_name'),
    	'language' => 'en',
    	'options' => ['placeholder' => 'Select a customer ...'],
    	'pluginOptions' => [
      	  'allowClear' => true
    	],
	]);

    echo $form->field($model, 'balance')->textInput(['maxlength' => true,'type'=>'number']);

    ?>
   

    <div class="form-group pull-right">
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
        <?php } ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
