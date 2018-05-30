<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\services\Test;
use kartik\sortinput\SortableInput;

$TestList= ArrayHelper::map(Test::find()->orderBy('testname')->all(),'test_id','testname');


/* @var $this yii\web\View */
/* @var $model common\models\services\Workflow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workflow-form" style="padding-bottom: 10px">

    <?php $form = ActiveForm::begin(); ?>

                    'allowClear' => true
    <div class="row">
             <div class="col-md-6">
             <?= $form->field($model, 'test_id')->widget(Select2::classname(), [
                'data' => $TestList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Test'],
                'pluginOptions' => [
                ],
             ])->label("Test"); ?>
             </div>

             <div class="col-md-6">
             <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>
             </div>
         </div>
    <?php
        // echo Sortable::widget([
        //     'type' => Sortable::TYPE_LIST,
        //     'items' => [
        //         ['content' => 'Item # 1'],
        //         ['content' => 'Item # 2'],
        //         ['content' => 'Item # 3'],
        //     ]   
        // ]);

        // echo $form->field($model,'workflow')->widget(SortableInput::classname(),
        // [
        //     // 'type' => SortableInput::TYPE_LIST,
        //     'items' => [
        //         ['content' => 'Item # 1'],
        //         ['content' => 'Item # 2'],
        //         ['content' => 'Item # 3'],
        //     ]   
        // ]);
        echo SortableInput::widget([
            'model' => $model,
            'attribute' => 'workflow',
            'hideInput' => false,
            'delimiter' => '~',
            'items' => [
                1 => ['content' => 'Item # 1'],
                2 => ['content' => 'Item # 2'],
                3 => ['content' => 'Item # 3'],
                4 => ['content' => 'Item # 4', 'disabled'=>true],
            ]   
        ]);

    ?>
    <?= $form->field($model, 'workflow')->textInput(['maxlength' => true]) ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>

</div>
