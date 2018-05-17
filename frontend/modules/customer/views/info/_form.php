<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\lab\Businessnature;
use common\models\lab\Industrytype;
use common\models\lab\Customertype;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

// use common\components\GooglePlacesAutoComplete;
// use dosamigos\google\places\Search;
/* @var $model common\models\lab\Customer */
/* @var $form yii\widgets\ActiveForm */ 
//$this->registerJsFile("/js/customer/googleplace.js"); 
?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= \Yii::$app->params['googlekey']?>&libraries=places"></script>

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
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
            <STRONG>Select Location Here</STRONG><br>
            <input id="searchTextField" type="text" size="50"/>
            <div id="output"></div><br /><br />     
            <div id="map" style="width: auto;height: 400px;"></div> 

            </div>
        </div>  
    </div>
    <div class="col-md-6">
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
             <div class="col-md-6">
                 <?= $form->field($model, 'address')->textarea(['maxlength' => true,'readonly'=>'true']) ?>

                <?= $form->field($model, 'latitude')->textInput(['readonly'=>'true']) ?>

                <?= $form->field($model, 'longitude')->textInput(['readonly'=>'true']) ?>
            </div>
        </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    


    

    <?php ActiveForm::end(); ?>
</div>


   


 

<?php 

$this->registerJsFile("/js/customer/autocomplete.js");
$this->registerJsFile("/js/customer/google-map-marker.js");

?>
        
