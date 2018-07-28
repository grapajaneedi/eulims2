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
use yii\helpers\Url;

$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');
$testnamelist= ArrayHelper::map(Testname::find()->all(),'testname_id','testName');

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sampletypetestname */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sampletypetestname-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'sampletype_id')->widget(Select2::classname(),[
                    'data' => $sampletypelist,
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id'=>'sample-testcategory_id'],
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Sample Type'],
            ])
    ?>

    <?= $form->field($model,'testname_id')->widget(Select2::classname(),[
                    'data' => $testnamelist,
                    'theme' => Select2::THEME_KRAJEE,
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Sample Type'],
            ])
    ?>




    <?= $form->field($model, 'added_by')->textInput(['maxlength' => true]) ?>
    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
