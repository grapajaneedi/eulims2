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
use common\models\lab\TestName;
use common\models\lab\Methodreference;
use yii\helpers\Url;

$testnamelist= ArrayHelper::map(Testname::find()->all(),'testname_id','testName');
$methodlist= ArrayHelper::map(Methodreference::find()->all(),'method_reference_id','method');

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testnamemethod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testnamemethod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'testname_id')->widget(Select2::classname(),[
                    'data' => $testnamelist,
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id'=>'sample-testcategory_id'],
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Test Name'],
            ])
    ?>

   <?= $form->field($model,'method_id')->widget(Select2::classname(),[
                    'data' => $methodlist,
                    'theme' => Select2::THEME_KRAJEE,
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Test Name'],
            ])
    ?>


    <div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'create_time')->textInput() ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'update_time')->textInput() ?>
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
