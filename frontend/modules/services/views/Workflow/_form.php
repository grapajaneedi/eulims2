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

$model->test_id=$test_id;
//configures the items for the workflow

?>

<div class="workflow-form" style="padding-bottom: 10px">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
             <div class="col-md-6">
             <?= $form->field($model, 'test_id')->widget(Select2::classname(), [
                'data' => $TestList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Test','disabled'=>true],
                'pluginOptions' => [
                ],
             ])->label("Test"); ?>
             </div>

             <div class="col-md-6">
             <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>
             </div>
         </div>


    <?php
    // Scenario # 5:Connected sortables where one can modify connected sortable inputs.
echo '<div class="row">';
echo '<div class="col-sm-6">';
        

        echo $form->field($model,'workflow')->widget(SortableInput::classname(),
        [
            // 'type' => SortableInput::TYPE_LIST,
            'sortableOptions' => [
                'connected'=>true,
            ],
            'hideInput' => false,
            'items' => [
                ['content' => 'Item # 1'],
                ['content' => 'Item # 2'],
                ['content' => 'Item # 3'],
            ],
            'options' => ['class'=>'form-control', 'readonly'=>true]
        ]);

    
echo '</div>';
echo '<div class="col-sm-6">';
echo '<strong>Procedures</strong>';
echo SortableInput::widget([
    'name'=>'kv-conn-2',
    'items' => [
        10 => ['content' => 'Item # 10'],
        20 => ['content' => 'Item # 20'],
        30 => ['content' => 'Item # 30'],
        40 => ['content' => 'Item # 40'],
        50 => ['content' => 'Item # 50'],
    ],
    'hideInput' => false,
    'sortableOptions' => [
        'itemOptions'=>['class'=>'alert alert-warning'],
        'type' => 'grid',
        'connected'=>true,
    ],
    'options' => ['class'=>'form-control', 'readonly'=>true]
]);
echo '</div>';
echo '</div>';
echo Html::resetButton('Reset Form', ['class'=>'btn btn-default']);
    ?>
    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    $('#workflow-test_id').select2({
        disabled: true
    });
</script>
