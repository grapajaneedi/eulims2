<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\lab\Businessnature;
use common\models\lab\Industrytype;
use common\models\lab\Customertype;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\address\MunicipalityCity;
use common\models\address\Province;
use common\models\address\Barangay;

// use common\components\GooglePlacesAutoComplete;
// use dosamigos\google\places\Search;
/* @var $model common\models\lab\Customer */
/* @var $form yii\widgets\ActiveForm */ 
//$this->registerJsFile("/js/customer/googleplace.js"); 
?>
<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <!-- <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'rstl_id')->textInput() ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'customer_code')->textInput(['maxlength' => true]) ?>
        </div>
    </div> -->
    
    
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
            <?= $form->field($model, 'head')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
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
            <?php 
            echo $form->field($model, 'business_nature_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Businessnature::find()->all(), 'business_nature_id', 'nature'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select  ...'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
            ]);
            ?>
            </div>
            <div class="col-md-4">
             <?php 
            echo $form->field($model, 'industrytype_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Industrytype::find()->all(), 'industrytype_id', 'industry'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select  ...'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
            ]);
            ?>
            </div>
            <div class="col-md-4">
            <?php 
            echo $form->field($model, 'customer_type_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Customertype::find()->all(), 'customertype_id', 'type'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select  ...'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
            ]);
            ?>
            </div>
        </div>
        <div class="row">
             <div class="col-md-6" style="border-right: 4px dotted blue;">
               <?= Html::button('<span class="glyphicon glyphicon-search"></span> Locate', ['value'=>'/customer/info/create', 'class' => 'btn btn-small btn-success','title' => Yii::t('app', "Locate Customer"),'onclick'=>"ShowGModal('Locate Customer',true,'900px')"]); ?>

                 <?= $form->field($model, 'address')->textarea(['maxlength' => true,'readonly'=>'true']) ?>

                <?= $form->field($model, 'latitude')->textInput(['readonly'=>'true']) ?>

                <?= $form->field($model, 'longitude')->textInput(['readonly'=>'true']) ?>
            </div>
            <div class="col-md-6">
                <?php 
                // echo $form->field($model, 'business_nature_id')->widget(Select2::classname(), [
                //     'data' => ArrayHelper::map(Businessnature::find()->all(), 'business_nature_id', 'nature'),
                //     'language' => 'en',
                //     'options' => ['placeholder' => 'Select  ...'],
                //     'pluginOptions' => [
                //       'allowClear' => true
                //     ],
                // ]);
                ?>

                <?php 
                echo $form->field($model, 'municipalitycity_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(MunicipalityCity::find()->all(), 'id', 'municipality'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select  ...'],
                    'pluginOptions' => [
                      'allowClear' => true
                    ],
                ]);
                ?>

                <?php 
                echo $form->field($model, 'barangay_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Barangay::find()->all(), 'barangay_id', 'barangay'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select  ...'],
                    'pluginOptions' => [
                      'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    
    


    

    <?php ActiveForm::end(); ?>
</div>