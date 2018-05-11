<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\GooglePlacesAutoComplete;
use dosamigos\google\places\Search;
/* @var $model common\models\lab\Customer */
/* @var $form yii\widgets\ActiveForm */ 
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

    <!-- <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'rstl_id')->textInput() ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'customer_code')->textInput(['maxlength' => true]) ?>
        </div>
    </div> -->

    <div class="row">
        <div class="col-md-4">
        <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
        <?= $form->field($model, 'business_nature_id')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'industrytype_id')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'customer_type_id')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
        <STRONG>Select Location Here</STRONG>
        <?php
            echo GooglePlacesAutoComplete::widget([
                'name' => 'place',
                'value' => 'Zamboanga',
                'options'=>['class'=>'form-control']
            ]);
        ?>
        <div id="div_services" class="small-box bg-aqua " style="border-radius: 20px">
        <strong>MAP</strong>
            <div id="map"></div>
        </div>
        </div>
        <div class="col-md-6">
         <?= $form->field($model, 'address')->textarea(['maxlength' => true,'readonly'=>'true']) ?>

        <?= $form->field($model, 'latitude')->textInput(['readonly'=>'true']) ?>

        <?= $form->field($model, 'longitude')->textInput(['readonly'=>'true']) ?>
        </div>
    </div>

    <div class="row">
       
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
