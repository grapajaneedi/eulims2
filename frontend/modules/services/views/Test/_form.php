<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

use common\models\lab\Lab;
use common\models\services\Testcategory;
use common\models\services\Sampletype;

/* @var $this yii\web\View */
/* @var $model common\models\services\Test */
/* @var $form yii\widgets\ActiveForm */

$Testcategorylist= ArrayHelper::map(Testcategory::find()->all(),'testcategory_id','category_name');
$Sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sample_type_id','sample_type');
$LabList= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');

?>

<div class="test-form" style="padding-bottom: 10px">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
             <div class="col-md-6">
                 <?= $form->field($model, 'testname')->textInput(['maxlength' => true]) ?>
             </div>

             <div class="col-md-6">
                 <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>
             </div>
         </div>

        <div class="row">
             <div class="col-md-6">
                 <?= $form->field($model, 'references')->textInput(['maxlength' => true]) ?>
             </div>

            <div class="col-md-6">
                 <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
             <div class="col-md-6">
                  <?= $form->field($model, 'duration')->textInput() ?>
            </div>

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
         </div>

        <div class="row">
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

            <div class="col-md-6">
                <?= $form->field($model, 'lab_id')->widget(Select2::classname(), [
                      'data' => $LabList,
                      'language' => 'en',
                      'options' => ['placeholder' => 'Select lab'],
                       'pluginOptions' => [
                       'allowClear' => true
                       ],
                ])->label("Lab"); ?>
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
