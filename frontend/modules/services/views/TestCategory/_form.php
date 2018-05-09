<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

use common\models\lab\Lab;
use common\models\services\testcategory;
use common\models\lab\sampletype;

/* @var $this yii\web\View */
/* @var $model common\models\lab\TestCategory */
/* @var $form yii\widgets\ActiveForm */
$LabList= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');
?>
<div class="test-category-form" style="padding-bottom: 10px">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'lab_id')->widget(Select2::classname(), [
                'data' => $LabList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select lab'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
    ])->label("Lab"); ?>
    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>
    
    <div class="form-group pull-right">
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
