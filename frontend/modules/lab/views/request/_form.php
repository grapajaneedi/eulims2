<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;
use kartik\datetime\DateTimePicker;
use common\models\lab\Customer;
use yii\web\JsExpression;
use kartik\datecontrol\DateControl;
use common\models\lab\Paymenttype;
use common\models\lab\Discount;
use common\models\lab\Modeofrelease;
use common\models\lab\Purpose;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */
/* @var $form yii\widgets\ActiveForm */
$JS=<<<SCRIPT
    $("input[name=Request[payment_type_id]]").on('change', function() {
        if ($(this).val() == 1) {
           alert("OK");
        }
    }); 
SCRIPT;
//$this->registerJs($JS);
?>

<div class="request-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'rstl_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'request_ref_num')->hiddenInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'posted')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'status_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'modeofrelease_ids')->hiddenInput(['id'=>'modeofrelease_ids'])->label(false) ?>
    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'report_due')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'total')->hiddenInput(['maxlength' => true])->label(false) ?>
<div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'lab_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Lab::find()->all(),'lab_id','labname'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select Lab'],
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
    $cust_name = empty($model->customer) ? '' : Customer::findOne($model->customer)->customer_name;
    echo $form->field($model, 'customer_id')->widget(Select2::classname(), [
        'initValueText' => $cust_name, // set the initial display text
        'options' => ['placeholder' => 'Search for a customer ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term,id:1}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(Customer) { return Customer.text; }'),
            'templateSelection' => new JsExpression('function (Customer) { return Customer.text; }'),
        ],
    ])->label('Customer');
    ?>
    </div>
    <div class="col-md-6">
        <label class="control-label">Payment Type</label>
        <div class="col-md-12">
        <?php echo $form->field($model, 'payment_type_id')->radioList(
            ArrayHelper::map(Paymenttype::find()->all(),'payment_type_id','type')
        )->label(false); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <?php  
    echo '<label class="control-label">Mode of ReleaseIDs</label>';
    echo Select2::widget([
        'name' => 'modeofreleaseids',
        'id' => 'modeofreleaseids',
        'data' => ArrayHelper::map(Modeofrelease::find()->all(),'modeofrelease_id','mode'),
        'value'=>$model->modeofrelease_ids,
        'options' => [
            'placeholder' => 'Select provinces ...',
            'multiple' => true
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
        'options' => ['placeholder' => 'Select Discount'],
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
        'options' => ['placeholder' => 'Select Purpose'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Purpose'); ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'discount')->textInput(['maxlength' => true,'readonly'=>true,'style'=>'background-color: white']) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'conforme')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'receivedBy')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<div class="row">
    <div class="row" style="float: right;padding-right: 30px">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-danger']) ?>
        <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
