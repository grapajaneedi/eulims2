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
use common\components\Functions;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */
/* @var $form yii\widgets\ActiveForm */

$disabled= $model->posted ? true:false;
if($disabled){
    $Color="#eee";
}else{
    $Color="white";
}
if($model->lab_id==3){
    $PanelStyle='';
}else{
    $PanelStyle='display: none';
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
        ],
        'pluginEvents'=>[
            "change" => "function() { 
                if(this.value==3){//Metrology
                   $('#div_met').show();
                }else{
                   $('#div_met').hide();
                }

            }",
        ]
    ])->label('Laboratory'); ?>
    </div>
    <div class="col-md-6">
    <label class="control-label">Request Date</label>
    <?php 
    echo DateTimePicker::widget([
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
	]
    ]); 
    ?>
    </div>
</div>
<div class="panel panel-success" id="div_met" style="<?= $PanelStyle ?>">
    <div class="panel-heading">Metrology Request Details</div>
    <div class="row" style="padding-left: 5px">
        <div class="col-md-6">
            <label class="control-label">Recommended Due Date</label>
            <div class="col-md-12">
                <?php
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'recommended_due_date',
                    'readonly' => true,
                    'disabled' => $disabled,
                    'options' => ['placeholder' => 'Enter Date'],
                    'value' => function($model) {
                        return date("m/d/Y", $model->recommended_due_date);
                    },
                    'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd'
                    ],
                    'pluginEvents' => [
                        "change" => "function() {  }",
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <label class="control-label">Estimated Date Completion</label>
            <div class="col-md-12">
                <?php
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'est_date_completion',
                    'readonly' => true,
                    'disabled' => $disabled,
                    'options' => ['placeholder' => 'Enter Date'],
                    'value' => function($model) {
                        return date("m/d/Y", $model->est_date_completion);
                    },
                    'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd'
                    ],
                    'pluginEvents' => [
                        "change" => "function() {  }",
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="row" style="padding-left: 5px">
        <div class="col-md-6">
            <label class="control-label">Date Release of Equipment</label>
            <div class="col-md-12">
                <?php
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'equipment_release_date',
                    'readonly' => true,
                    'disabled' => $disabled,
                    'options' => ['placeholder' => 'Enter Date'],
                    'value' => function($model) {
                        return date("m/d/Y", $model->equipment_release_date);
                    },
                    'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd'
                    ],
                    'pluginEvents' => [
                        "change" => "function() {  }",
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <label class="control-label">Date Release of Certificate</label>
            <div class="col-md-12">
                <?php
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'certificate_release_date',
                    'readonly' => true,
                    'disabled' => $disabled,
                    'options' => ['placeholder' => 'Enter Date'],
                    'value' => function($model) {
                        return date("m/d/Y", $model->certificate_release_date);
                    },
                    'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd'
                    ],
                    'pluginEvents' => [
                        "change" => "function() {  }",
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="row" style="padding-left: 5px">
        <div class="col-md-6">
            <label class="control-label">Position</label>
            <div class="col-md-12">
            <?= $form->field($model, 'position')->textInput(['readonly' => $disabled])->label(false) ?>
            </div>
        </div>
        <div class="col-md-6">
            <label class="control-label">Items Receive By</label>
            <div class="col-md-12">
            <?= $form->field($model, 'items_receive_by')->textInput(['readonly' => $disabled])->label(false) ?>
            </div>
        </div>
    </div>
    <div class="row" style="padding-left: 5px">
        <div class="col-md-6">
            <label class="control-label">Released By</label>
            <div class="col-md-12">
            <?= $form->field($model, 'released_by')->textInput(['readonly' => $disabled])->label(false) ?>
            </div>
        </div>
        <div class="col-md-6">
            <label class="control-label">Received By</label>
            <div class="col-md-12">
            <?= $form->field($model, 'received_by')->textInput(['readonly' => $disabled])->label(false) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
            <div class="input-group">
                <?php
                $func = new Functions();
                echo $func->GetCustomerList($form, $model, $disabled,'Customer');
                ?> 
                <span class="input-group-btn" style="padding-top: 25.5px">
                    <button onclick="LoadModal('Create New Customer', '/customer/info/create');" class="btn btn-default" type="button"><i class="fa fa-user-plus"></i></button>
                </span>
            </div>
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
            'placeholder' => 'Select Mode of Release...',
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
        <?php if($model->isNewRecord){ ?>
        <?= Html::resetButton('Reset', ['disabled'=>$disabled,'class' => 'btn btn-danger']) ?>
        <?php } ?>
        <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
