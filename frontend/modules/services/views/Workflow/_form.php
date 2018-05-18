<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\services\Test;

$TestList= ArrayHelper::map(Test::find()->orderBy('testname')->all(),'test_id','testname');


/* @var $this yii\web\View */
/* @var $model common\models\services\Workflow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workflow-form" style="padding-bottom: 10px">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
             <div class="col-md-6">
             <?= $form->field($model, 'test_id')->widget(Select2::classname(), [
                'data' => $TestList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Test'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
             ])->label("Test"); ?>
             </div>

             <div class="col-md-6">
             <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>
             </div>
         </div>


 

   

    

    <?= $form->field($model, 'workflow')->textInput(['maxlength' => true]) ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>

</div>
