<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;
use kartik\datetime\DateTimePicker;
use common\models\lab\Customer;
use yii\web\JsExpression;
use kartik\widgets\DatePicker;
use common\models\lab\Paymenttype;
use common\models\lab\Discount;
use common\models\lab\Modeofrelease;
use common\models\lab\Purpose;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */
/* @var $form yii\widgets\ActiveForm */

// script to parse the results into the format expected by Select2
$dataExp = <<< SCRIPT
  function (params, page) {
    return {
      q: params.term, // search term
    };
  }
SCRIPT;

$dataResults = <<< SCRIPT
  function (data, page) {
    return {
      results: data.results
    };
  }
SCRIPT;
$disabled= $model->posted ? true:false;
if($disabled){
    $Color="#eee";
}else{
    $Color="white";
}
?>

<div class="request-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'rstl_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'request_ref_num')->hiddenInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'posted')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'status_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'modeofrelease_ids')->hiddenInput(['id'=>'modeofrelease_ids'])->label(false) ?>
    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'total')->hiddenInput(['maxlength' => true])->label(false) ?>
<div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'lab_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Lab::find()->all(),'lab_id','labname'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select Lab','disabled'=>$disabled],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ])->label('Laboratory'); ?>
    </div>
    <div class="col-md-6">
    <label class="control-label">Request Date</label>
    <?php echo DateTimePicker::widget([
	'model' => $model,
	'attribute' => 'request_datetime',
        'readonly'=>true,
        'disabled'=>$disabled,
	'options' => ['placeholder' => 'Enter Date'],
        'value'=>function($model){
             return date("m/d/Y h:i:s P",$model->request_datetime);
        },
	'pluginOptions' => [
            'autoclose' => true,
            'removeButton' => false,
            'format' => 'yyyy-mm-dd h:i:s'
	],
        'pluginEvents'=>[
            "change" => "function() { alert('change'); }",
        ]
    ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <?php
    $url = \yii\helpers\Url::to(['customerlist']);
    // Get the initial city description
    $cust_name = empty($model->customer) ? '' : Customer::findOne($model->customer_id)->customer_name;
    echo $form->field($model, 'customer_id')->widget(Select2::classname(), [
        'initValueText' => $cust_name, // set the initial display text
        'options' => ['placeholder' => 'Search for a customer ...','disabled'=>$disabled],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression($dataExp),
                'results' => new JsExpression($dataResults)
            ]
        ],
    ])->label('Customer');
    ?>
    </div>
    <div class="col-md-6">
        <label class="control-label">Payment Type</label>
        <div class="col-md-12">
        <?php echo $form->field($model, 'payment_type_id')->radioList(
            ArrayHelper::map(Paymenttype::find()->all(),'payment_type_id','type'),
            ['itemOptions' => ['disabled' => $disabled]]
        )->label(false); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <?php  
    echo '<label class="control-label">Mode of Release</label>';
    echo Select2::widget([
        'name' => 'modeofreleaseids',
        'id' => 'modeofreleaseids',
        'data' => ArrayHelper::map(Modeofrelease::find()->all(),'modeofrelease_id','mode'),
        'value'=>explode(',',$model->modeofrelease_ids),
        'options' => [
            'placeholder' => 'Select provinces ...',
            'multiple' => true,
            'disabled'=>$disabled
        ],
        'pluginEvents' => [
            "change" => "function() { 
                $('#modeofrelease_ids').val($(this).val());
            }
            ",
        ]
    ]);
    ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'discount_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Discount::find()->all(),'discount_id','type'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select Discount','disabled'=>$disabled],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'pluginEvents'=>[
            "change" => 'function() { 
                var discountid=this.value;
                $.post("/ajax/getdiscount/", {
                        discountid: discountid
                    }, function(result){
                    if(result){
                       $("#request-discount").val(result.rate);
                    }
                });
            }
        ',]
    ])->label('Discount'); ?>   
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'purpose_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Purpose::find()->all(),'purpose_id','name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select Purpose','disabled'=>$disabled],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Purpose'); ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'discount')->textInput(['maxlength' => true,'readonly'=>true,'style'=>'background-color: '.$Color]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <?php echo $form->field($model, 'is_referral')->widget(SwitchInput::classname(), [
        'disabled' => $disabled,
        'pluginOptions' => [
            'size' => 'small',
            'handleWidth'=>'53',
            'onColor' => 'success',
            'offColor' => 'danger',
            'onText' => 'Yes',
            'offText' => 'No',
        ]
    ])->label("Referral"); ?>
    </div>
    <div class="col-md-6">
    <label class="control-label">Report Due</label>
    <?php echo DatePicker::widget([
	'model' => $model,
	'attribute' => 'report_due',
        'readonly'=>true,
        'disabled' => $disabled,
	'options' => ['placeholder' => 'Report Due'],
        'value'=>function($model){
             return date("m/d/Y",$model->report_due);
        },
	'pluginOptions' => [
            'autoclose' => true,
            'removeButton' => false,
            'format' => 'yyyy-mm-dd'
	],
        'pluginEvents'=>[
            "change" => "function() { alert('change'); }",
        ]
    ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'conforme')->textInput(['readonly' => $disabled]) ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'receivedBy')->textInput(['readonly' => true]) ?>
    </div>
</div>
<div class="row">
    <div class="row" style="float: right;padding-right: 30px">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['disabled'=>$disabled,'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['disabled'=>$disabled,'class' => 'btn btn-danger']) ?>
        <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
