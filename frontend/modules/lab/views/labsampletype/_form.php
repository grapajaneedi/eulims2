<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;
use common\models\lab\Sampletype;
use yii\helpers\Url;


$lablist= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');
$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');

/* @var $this yii\web\View */
/* @var $model common\models\lab\Labsampletype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="labsampletype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'lab_id')->widget(Select2::classname(),[
                    'data' => $lablist,
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id'=>'sample-testcategory_id'],
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Lab'],
            ])
    ?>

 <?= $form->field($model,'sampletypeId')->widget(Select2::classname(),[
                    'data' => $sampletypelist,
                    'theme' => Select2::THEME_KRAJEE,
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Lab'],
            ])
    ?>


    <?= $form->field($model, 'effective_date')->widget(DatePicker::classname(), [
        'readonly'=>true,
        'options' => ['placeholder' => 'Select Date'],
            'value'=>function($model){
                return date("m/d/Y",$model->effective_date);
            },
        'pluginOptions' => [
                'autoclose' => true,
                'removeButton' => false,
                'format' => 'yyyy-mm-dd'
        ],
            
    ])->label('Effectivity Date'); ?>

    <?= $form->field($model, 'added_by')->textInput(['maxlength' => true]) ?>


  

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
