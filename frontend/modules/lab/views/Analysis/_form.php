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
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
use common\models\services\Test;
use common\models\services\Sampletype;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */

// $Testcategorylist= ArrayHelper::map(Testcategory::find()->all(),'testcategory_id','category_name');
// $Sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sample_type_id','sample_type');
// $TestList= ArrayHelper::map(Test::find()->orderBy('testname')->all(),'test_id','testname');

?>

<div class="analysis-form">

    <?php $form = ActiveForm::begin(); ?>
    <!-- <div class="alert alert-info" style="background: #d9edf7 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d">Fields with <i class="fa fa-asterisk text-danger"></i> are required.</p>
     
    </div> -->

    <?= GridView::widget([
        'dataProvider' => $sampleDataProvider,
        //'filterModel' => $samplesearchmodel,
        'pjax'=>true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive'=>false,
        'containerOptions'=>[
            'style'=>'overflow:auto; height:180px',
        ],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'floatHeaderOptions' => ['scrollingTop' => true],
        'columns' => [
               [
            'class' => '\kartik\grid\CheckboxColumn',
         ],
            'samplename',
            [
                'attribute'=>'description',
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function($data){
                    return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".$data->sampling_date."</b></span>,&nbsp;".$data->description : $data->description;
                },
                'contentOptions' => ['style' => 'width:70%; white-space: normal;'],
            ],
        ],
    ]); ?>

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
        <?= $form->field($model,'testcategory_id')->widget(Select2::classname(),[
                        'data' => $testcategory,
                        'theme' => Select2::THEME_KRAJEE,
                        //'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => ['id'=>'sample-testcategory_id'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Test category'],
                ])
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'sample_type_id')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'data'=>$sampletype,
                'options'=>['id'=>'sample-sample_type_id'],
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['sample-testcategory_id'],
                    'placeholder'=>'Select Sample type',
                    'url'=>Url::to(['/lab/sample/listsampletype']),
                    'loadingText' => 'Loading Sampletype...',
                ]
            ])
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
             <?php
            //   $form->field($model, 'test_id')->widget(Select2::classname(), [
            //             'data' => $TestList,
            //             'language' => 'en',
            //             'options' => ['placeholder' => 'Select Test'],
            //             'pluginOptions' => [
            //             'allowClear' => true
            //             ],
            //      ])->label("Test");
                  ?>

        <?= $form->field($model, 'test_id')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'data'=>$test,
                'options'=>['id'=>'sample-test_id'],
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['sample-sample_type_id'],
                    'placeholder'=>'Select Test',
                    'url'=>Url::to(['/lab/analysis/listtest']),
                    'loadingText' => 'Loading Test...',
                ]
            ])
            ?>
        </div>
           <div class="col-sm-6">
        <?= $form->field($model, 'method')->textInput(['readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
              <?= $form->field($model, 'references')->textInput(['readonly' => true]) ?>
        </div>
           <div class="col-sm-6">
           <?= $form->field($model, 'quantity')->textInput(['readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
              <?= $form->field($model, 'fee')->textInput(['readonly' => true]) ?>
        </div>
           <div class="col-sm-6">

           <label class="control-label">Analysis Date</label>
                <?php echo DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'date_analysis',
                'readonly'=>true,
                'options' => ['placeholder' => 'Enter Date'],
                    'value'=>function($model){
                        return date("m/d/Y h:i:s P",$model->date_analysis);
                    },
                'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd h:i:s'
                ],
                    'pluginEvents'=>[
                        "change" => "function() { alert('change'); }",
                    ]
                ]); ?>
        </div>
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
