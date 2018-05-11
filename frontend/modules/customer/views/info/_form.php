<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
<<<<<<< HEAD
use common\components\GooglePlacesAutoComplete;
use dosamigos\google\places\Search;
=======

/* @var $this yii\web\View */
>>>>>>> parent of cfddb1aa... Merge branch 'master' of https://github.com/TheVBProgrammer/eulims2
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
<<<<<<< HEAD
        <div class="col-md-4">
        <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
=======
        <div class="col-md-6">
        <?= $form->field($model, 'municipalitycity_id')->textInput() ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'barangay_id')->textInput() ?>
>>>>>>> parent of cfddb1aa... Merge branch 'master' of https://github.com/TheVBProgrammer/eulims2
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
<<<<<<< HEAD
        <div class="col-md-4">
        <?= $form->field($model, 'business_nature_id')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'industrytype_id')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'customer_type_id')->textInput() ?>
=======
        <div class="col-md-6">
        <?= $form->field($model, 'district')->textInput() ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
>>>>>>> parent of cfddb1aa... Merge branch 'master' of https://github.com/TheVBProgrammer/eulims2
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
<<<<<<< HEAD
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
=======
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
        <?= $form->field($model, 'business_nature_id')->textInput() ?>
>>>>>>> parent of cfddb1aa... Merge branch 'master' of https://github.com/TheVBProgrammer/eulims2
        </div>
        <div class="col-md-6">
         <?= $form->field($model, 'address')->textarea(['maxlength' => true,'readonly'=>'true']) ?>

        <?= $form->field($model, 'latitude')->textInput(['readonly'=>'true']) ?>

        <?= $form->field($model, 'longitude')->textInput(['readonly'=>'true']) ?>
        </div>
    </div>

    <div class="row">
<<<<<<< HEAD
       
    </div>

=======
        <div class="col-md-6">

        </div>
        <div class="col-md-6">

        </div>
    </div>    
>>>>>>> parent of cfddb1aa... Merge branch 'master' of https://github.com/TheVBProgrammer/eulims2

    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
