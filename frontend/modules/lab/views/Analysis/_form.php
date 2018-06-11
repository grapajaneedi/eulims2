<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;
use kartik\widgets\DateTimePicker;
//use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="analysis-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="alert alert-info" style="background: #d9edf7 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d">Fields with <i class="fa fa-asterisk text-danger"></i> are required.</p>
     
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'analysis_id',
            'date_analysis',
            'rstl_id',
            'pstcanalysis_id',
            'request_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?= $form->field($model, 'date_analysis')->textInput() ?>

    <?= $form->field($model, 'rstl_id')->textInput() ?>

    <?= $form->field($model, 'pstcanalysis_id')->textInput() ?>

    <?= $form->field($model, 'request_id')->textInput() ?>

    <?= $form->field($model, 'sample_id')->textInput() ?>

    <?= $form->field($model, 'sample_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'testname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'references')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_id')->textInput() ?>

    <?= $form->field($model, 'cancelled')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'is_package')->textInput() ?>

   

 

    <div class="form-group" style="padding-bottom: 3px;">
        <div style="float:right;">
            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::button('Cancel', ['class' => 'btn', 'onclick'=>'closeDialog()']) ?>
            <br>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
