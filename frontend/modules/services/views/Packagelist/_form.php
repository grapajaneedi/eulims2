<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\lab\Lab;
use common\models\services\Testcategory;
use common\models\services\Sampletype;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;
use common\models\services\Test;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Packagelist */
/* @var $form yii\widgets\ActiveForm */

$Testcategorylist= ArrayHelper::map(Testcategory::find()->all(),'testcategory_id','category_name');
$Sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sample_type_id','sample_type');


?>

<div class="packagelist-form" style="padding-bottom: 10px">

    <?php $form = ActiveForm::begin(); ?>

    

    <div class="row">
             <div class="col-md-6">
              
                 <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
             </div>

             <div class="col-md-6">
             <?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>
             
             </div>
         </div>

         <div class="row">
             <div class="col-md-6">
             <?= $form->field($model, 'testcategory_id')->widget(Select2::classname(), [
                        'data' => $Testcategorylist,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Select Test Category'],
                        'pluginOptions' => [
                        'allowClear' => true
                        ],
                 ])->label("Test Category"); ?>
           
             </div>

             <div class="col-md-6">
             <?= $form->field($model, 'sample_type_id')->widget(Select2::classname(), [
                        'data' => $Sampletypelist,
                        'language' => 'en',
                         'options' => ['placeholder' => 'Select Sample Type'],
                         'pluginOptions' => [
                         'allowClear' => true
                        ],
                ])->label("Sample Type"); ?>
            
             </div>
         </div>

         <div class="row">
             <div class="col-md-6">
             <?= $form->field($model, 'tests')->textInput(['maxlength' => true]) ?>
             </div>
             <div class="col-md-6">
             <?= $form->field($model, 'rstl_id')->textInput() ?>     
             </div>
         </div>
         
    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
