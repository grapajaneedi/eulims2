<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\lab\Customer;
use kartik\select2\Select2;
use common\components\Functions;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Customerwallet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customerwallet-form" style="padding-bottom: 10px">

    <?php  $form = ActiveForm::begin(); ?>

    <?php 

    $func=new Functions();
    echo $func->GetCustomerList($form,$model,false,"Customer");
    ?> 
   
    <?php
    echo $form->field($model, 'balance')->textInput(['maxlength' => true,'type'=>'number']);

    ?>
   

    <div class="form-group pull-right">
           <?php if(Yii::$app->request->isAjax){ ?>
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
           <?php } ?>

            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
     </div>

    <?php ActiveForm::end(); ?>

</div>
