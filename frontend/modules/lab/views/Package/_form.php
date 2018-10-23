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
use kartik\money\MaskMoney;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Package */
/* @var $form yii\widgets\ActiveForm */

$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');
?>

<div class="package-form">

    <?php $form = ActiveForm::begin(); ?>

   
    <?= $form->field($model,'sampletype_id')->widget(Select2::classname(),[
                    'data' => $sampletypelist,
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id'=>'sample-testcategory_id'],
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Sample Type'],
            ])
    ?>



    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
            echo $form->field($model, 'rate')->widget(MaskMoney::classname(), [
            'readonly'=>true,
            'options'=>[
                'style'=>'text-align: right'
            ],
            'pluginOptions' => [
               'prefix' => '₱ ',
               'allowNegative' => false,
            ]
           ])->label("Rate");
        ?>

  
    <?= $form->field($model, 'tests')->widget(DepDrop::classname(), [
            'type'=>DepDrop::TYPE_SELECT2,
            'data'=>$sampletype,
            'options'=>['id'=>'sample-sample_type_id',  'multiple' => true,],
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['sample-testcategory_id'],
                'placeholder'=>'Select Test Name',
                'url'=>Url::to(['/lab/analysis/listsampletype']),
                'loadingText' => 'Loading Test Names...',
            ]
        ])
        ?>
      <?= Html::textInput('sample_ids', '', ['class' => 'form-control', 'id'=>'sample_ids', 'type'=>'hidden'], ['readonly' => true]) ?>
<br>
    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
  $this->registerJs('var temp = [];');  

$this->registerJs("$('#sample-sample_type_id').on('change',function(){
    var id = $('#sample-sample_type_id').val();
  
    temp.push(id);

    $('#sample_ids').val(id);


        // $.ajax({
        //     url: '".Url::toRoute("package/getpackage")."',
        //     dataType: 'json',
        //     method: 'GET',
        //     data: {id: id},
        //     success: function (data, textStatus, jqXHR) {
               
        //        
            
        //         $('.image-loader').removeClass( \"img-loader\" );
        //         $('.image-loader').removeClass( \"img-loader\" );
        //     },
        //     beforeSend: function (xhr) {
        //         //alert('Please wait...');
        //         $('.image-loader').addClass( \"img-loader\" );
        //     },
        //     error: function (jqXHR, textStatus, errorThrown) {
        //         console.log('An error occured!');
        //         alert('Error in ajax request');
        //     }
        // });
});");
?>

</div>
