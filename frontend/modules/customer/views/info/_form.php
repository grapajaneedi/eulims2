<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\GooglePlacesAutoComplete;
use dosamigos\google\places\Search;
/* @var $model common\models\lab\Customer */
/* @var $form yii\widgets\ActiveForm */
//$js="//maps.googleapis.com/maps/api/js?key=AIzaSyBkbMSbpiE90ee_Jvcrgbb12VRXZ9tlzIc&amp;libraries=places&amp;language=en-US";
//$this->registerJsFile($js); 
$this->registerJsFile("/js/customer/googleplace.js"); 
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
        <?= $form->field($model, 'head')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'rstl_id')->textInput() ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'customer_code')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'customer_type_id')->textInput() ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
         <?= $form->field($model, 'address')->textInput(['maxlength' => true,'readonly'=>'true']) ?>

        <?= $form->field($model, 'latitude')->textInput(['readonly'=>'true']) ?>

        <?= $form->field($model, 'longitude')->textInput(['readonly'=>'true']) ?>
        </div>
        <div class="col-md-6">
        <p>Select Location Here</p>
        <?php
            echo GooglePlacesAutoComplete::widget([
                'name' => 'place',
                'value' => 'Zamboanga',
                'options'=>['class'=>'form-control']
            ]);
        ?>
        </div>
    </div>

   

    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'business_nature_id')->textInput() ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'industrytype_id')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
