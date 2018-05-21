<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\lab\Businessnature;
use common\models\lab\Industrytype;
use common\models\lab\Customertype;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\address\CityMunicipality;
use common\models\address\Province;
use common\models\address\Barangay;
use common\models\address\Region;

/* @var $model common\models\lab\Customer */
/* @var $form yii\widgets\ActiveForm */ 
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
               <?= Html::button('<span class="glyphicon glyphicon-search"></span> Locate', ['value'=>'/customer/info/create', 'class' => 'btn btn-small btn-primary','title' => Yii::t('app', "Locate Customer"),'onclick'=>"ShowGModal('Locate Customer',true,'900px')"]); ?>

                 <?= $form->field($model, 'address')->textarea(['maxlength' => true,'readonly'=>'true']) ?>

                <?= $form->field($model, 'latitude')->textInput(['readonly'=>'true']) ?>

                <?= $form->field($model, 'longitude')->textInput(['readonly'=>'true']) ?>
            </div>
            <div class="col-md-6">
                <label class="control-label">Region</label><br>
                <?php 
                echo Select2::widget([
                    'id'=>'cregion',
                    'name' => 'cregion',
                    'data' => ArrayHelper::map(Region::find()->all(), 'region_id', 'region'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'hideSearch' => false,
                    'options' => [
                        'placeholder' => 'Select a Region',
                    ],
                    'pluginOptions'=>array(
                        'ajax'=>array( 
                            'type'=>'POST',
                            'url'=>Yii::$app->urlManager->createUrl('/customer/info/getprovince'),
                            'update'=>'#cprovince',
                        ),
                    ),
                ]);
                ?>
                <br>
                <label class="control-label">Province</label><br>
                <?php 
                echo Select2::widget([
                    'id'=>'cprovince',
                    'name' => 'province',
                    'data' => ArrayHelper::map(Province::find()->all(), 'region_id', 'region'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'hideSearch' => false,
                    'options' => [
                        'placeholder' => 'Select a Province',
                    ],
                ]);
                ?>
                <br>
                <label class="control-label">Municipality</label><br>
                <?php 
                echo Select2::widget([
                    'id'=>'cmunicipality',
                    'name' => 'cmunicipality',
                    'data' => ArrayHelper::map(CityMunicipality::find()->all(), 'city_municipality_id', 'city_municipality'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'hideSearch' => false,
                    'options' => [
                        'placeholder' => 'Select a City/Municipality',
                    ]
                ]);
                ?>
                <br>
                <?php 
                echo $form->field($model, 'barangay_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Barangay::find()->all(), 'barangay_id', 'barangay'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select a Barangay'],
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