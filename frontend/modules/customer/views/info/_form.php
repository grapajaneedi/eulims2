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
use yii\helpers\Url;
use kartik\widgets\DepDrop;


/* @var $model common\models\lab\Customer */
/* @var $form yii\widgets\ActiveForm */ 
?>
<div class="customer-form"  style="padding-bottom: 10px">

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
                    'name' => 'cregion',
                    'data' => ArrayHelper::map(Region::find()->all(), 'region_id', 'region'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'hideSearch' => false,
                    'options' => [
                        'id'=>'cregion'
                    ],
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Region'],
                ]);
                ?>
                <br>
                <label class="control-label">Province</label><br>
                <?php 
                echo DepDrop::widget([
                    'type'=>DepDrop::TYPE_SELECT2,
                    'name' => 'province',
                    'data' => null,
                    // 'theme' => Select2::THEME_BOOTSTRAP,
                    // 'hideSearch' => false,
                    'options' => [
                        'id'=>'cprovince'
                    ],
                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['cregion'],
                        'placeholder'=>'Select Province',
                        'url'=>Url::to(['/customer/info/getprovince']),
                        'loadingText' => 'Loading provinces...',
                    ]
                ]);
                ?>
                <br>
                <label class="control-label">Municipality</label><br>
                 <?php 
                echo DepDrop::widget([
                    'type'=>DepDrop::TYPE_SELECT2,
                    'name' => 'municipality',
                    'data' => null,
                    'options' => [
                        'id'=>'cmunicipality'
                    ],
                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['cprovince'],
                        'placeholder'=>'Select Municipality',
                        'url'=>Url::to(['/customer/info/getmunicipality']),
                        'loadingText' => 'Loading cities or municipalities...',
                    ],
                    ]);
                ?>
                <br>

                <?= $form->field($model, 'barangay_id')->widget(DepDrop::classname(), [
                    'type'           => DepDrop::TYPE_SELECT2,
                    'data'           =>  $model->isNewRecord ? null : ArrayHelper::map(Barangay::find()->all(), 'barangay_id', 'barangay'),
                    'options'        => ['id' => 'customer-barangay_id', 'name' => 'Customer[barangay_id]'],
                    'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                    'pluginOptions'=>[
                        'depends'=>['cmunicipality'],
                        'placeholder'=>'Select Barangay',
                        'url'=>Url::to(['/customer/info/getbarangay']),
                        'loadingText' => 'Loading barangay...',
                    ],
                    'pluginEvents' => [ "depdrop:afterChange"=>"function(event, id, value) { 
                        if (value == '') { $('.mybtn').prop('disabled',true);}else{ $('.mybtn').prop('disabled',false); } }", ],
                ])->label('Barangay'); ?>


                 <?php 
                // echo DepDrop::widget([
                //     'type'=>DepDrop::TYPE_SELECT2,
                //     // 'name' => 'customer-barangay_id',
                //     'data' => $model->isNewRecord ? null : ArrayHelper::map(Barangay::find()->all(), 'barangay_id', 'barangay'),
                //     'options' => [
                //         'id'=>'customer-barangay_id',
                //         'name' => 'customer[barangay_id]',
                //         'required'=>true
                //     ],
                //     'model'=>$model,
                //     'attribute'=>'barangay_id',
                //     'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                //     'pluginOptions'=>[
                //         'depends'=>['cmunicipality'],
                //         'placeholder'=>'Select Barangay',
                //         'url'=>Url::to(['/customer/info/getbarangay']),
                //         'loadingText' => 'Loading barangay...',
                //     ]
                // ]);
                ?>
            </div>
        </div>
    <div class="form-group">
    </div>

    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success mybtn' : 'btn btn-primary mybtn','disabled'=>$model->isNewRecord ? true : false]) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
        
    </div>
    
    


    

    <?php ActiveForm::end(); ?>
</div>