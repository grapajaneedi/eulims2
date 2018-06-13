<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;
//use kartik\widgets\DateTimePicker;
//use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
use common\models\services\Test;


use common\models\services\Sampletype;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */


$Testcategorylist= ArrayHelper::map(Testcategory::find()->all(),'testcategory_id','category_name');
$Sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sample_type_id','sample_type');
$TestList= ArrayHelper::map(Test::find()->orderBy('testname')->all(),'test_id','testname');

?>

<div class="analysis-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="alert alert-info" style="background: #d9edf7 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d">Fields with <i class="fa fa-asterisk text-danger"></i> are required.</p>
     
    </div>

    <?= GridView::widget([
        'dataProvider' => $sampleDataProvider,
        //'filterModel' => $searchModel,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        // [
        //     'class' => '\kartik\grid\CheckboxColumn',
        //  ],
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],
               [
            'class' => '\kartik\grid\CheckboxColumn',
         ],
            'samplename',
        ],
    ]); ?>

    <?= $form->field($model, 'date_analysis')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'rstl_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'pstcanalysis_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'request_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'sample_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'sample_code')->hiddenInput(['maxlength' => true])->label(false)?>

    <?= $form->field($model, 'testname')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'method')->hiddenInput(['maxlength' => true])->label(false) ?>

   

    <?= $form->field($model, 'fee')->hiddenInput(['maxlength' => true])->label(false) ?>

   

    <?= $form->field($model, 'cancelled')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'is_package')->hiddenInput()->label(false)  ?>

    

   

        <div class="row">
        <div class="col-sm-6">
             <?= $form->field($model, 'testcategory_id')->widget(Select2::classname(), [
                        'data' => $Testcategorylist,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Select Test Category'],
                        'pluginOptions' => [
                        'allowClear' => true
                        ],
                 ])->label("Test Category"); ?>
        </div>
        <div class="col-sm-6">
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
        <div class="col-sm-6">
             <?= $form->field($model, 'test_id')->widget(Select2::classname(), [
                        'data' => $TestList,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Select Test'],
                        'pluginOptions' => [
                        'allowClear' => true
                        ],
                 ])->label("Test"); ?>
        </div>
           <div class="col-sm-6">
        <?= $form->field($model, 'method')->textInput() ?>
    </div>

    

    <div class="form-group" style="padding-bottom: 3px;">
        <div style="float:right;">
            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::button('Cancel', ['class' => 'btn', 'onclick'=>'closeDialog()']) ?>
            <br>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
