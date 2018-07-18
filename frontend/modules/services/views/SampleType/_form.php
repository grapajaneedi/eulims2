<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\services\Testcategory;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\services\Sampletype */
/* @var $form yii\widgets\ActiveForm */

$LabList= ArrayHelper::map(Testcategory::find()->orderBy('category_name')->all(),'testcategory_id','category_name');


?>

<div class="sample-type-form" style="padding-bottom: 10px">
<?php $form = ActiveForm::begin(); ?>
<?=
///////

//insert lab in sample type


$form->field($model,'testcategory_id')->widget(Select2::classname(),[
                        'data' => $testcategory,
                        'theme' => Select2::THEME_KRAJEE,
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

            /////////
            ?>

<div class="sampletype-form" style="padding-bottom: 10px">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'testcategory_id')->widget(Select2::classname(), [
                'data' => $LabList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Test Category'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
    ])->label("Test Category"); ?>

 

    <?= $form->field($model, 'sample_type')->textInput(['maxlength' => true]) ?>

  

    <div class="form-group pull-right">
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
