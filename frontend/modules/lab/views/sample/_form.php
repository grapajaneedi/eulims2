<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sample */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
if(count($sampletype) > 0){
    $data = $sampletype;
} else {
    //$data = array(''=>'No Barangay');
    $data = ['' => 'No Sampletype'] + $sampletype;
}
?>

<div class="sample-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if(empty($model->sample_id)): ?>
    <p><label>Sample Quantity</label></p>
    <div class="input-group" style="margin-bottom: 15px;">
        <span class="input-group-btn">
            <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="qnty">
                <span class="glyphicon glyphicon-minus"></span>
            </button>
        </span>
        <input type="text" name="qnty" class="form-control input-number" value="1" min="1" max="100" style="width: 50px;text-align: center;">
        <span class="input-group-btn" style="float:left;">
            <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="qnty">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </span>
    </div>
    <?php endif; ?>

    <?= $form->field($model,'test_category_id')->widget(Select2::classname(),[
                'data' => $testcategory,
                //'theme' => Select2::THEME_KRAJEE,
                'options' => ['id'=>'sample-test_category_id'],
                'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Testcategory'],
        ])
    ?>

    <?= $form->field($model, 'sample_type_id')->widget(DepDrop::classname(), [
        'type'=>DepDrop::TYPE_SELECT2,
        'data'=>$sampletype,
        'options'=>['id'=>'sample-sample_type_id'],
        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
        'pluginOptions'=>[
            'depends'=>['sample-test_category_id'],
            'placeholder'=>'Select Sampletype',
            'url'=>Url::to(['/lab/sample/listsampletype']),
            'loadingText' => 'Loading Sampletype...',
        ]
    ])
    ?>

    <?php
        if($labId == 2){
            //echo $form->field($model, 'sampling_date')->textInput();
            echo DatePicker::widget([
                'name' => 'Sample[sampling_date]',
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'value' => $model->sampling_date ? date('m/d/Y', strtotime($model->sampling_date)) : date('m/d/Y'),
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'mm/dd/yyyy'
                ]
            ]);
        } else {
            echo "";
        }
    ?>

    <?= $form->field($model, 'samplename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    //plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
</script>
