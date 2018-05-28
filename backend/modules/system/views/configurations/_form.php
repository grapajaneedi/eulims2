<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;
use common\models\system\Rstl;
use kartik\base\InputWidget;
use kartik\widgets\SwitchInput;
use common\models\lab\CodeTemplate;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Lab */
/* @var $form yii\widgets\ActiveForm */
$rstl_id=$GLOBALS['rstl_id'];
$RequestcodedTemplate= CodeTemplate::find()->where(['rstl_id'=>$rstl_id])->one();
$js=<<<SCRIPT
   $("#CollapseRequestcode").click(function(){
      $("#btnSubmit").toggle();
      $("#btnSaveRequestTemplate").toggle();
   });
   $("#btnSaveRequestTemplate").click(function(){
        $.post('/ajax/saverequesttemplate', {
            rstl_id: $("#RSTLSelect2").val(),
            rtemp: $("#RequestLaboratory").val()
        }, function(result){
            //Return values
            if(result.Status=='Failed'){
                bootbox.alert({
                    title: "EULIMS",
                    message: "Request Template Failed to Saved!",
                    size: 'medium'
                });
            }else{
                bootbox.alert({
                    title: "EULIMS",
                    message: "Request Template Successully Saved!",
                    size: 'medium'
                });
            }
        }); 
   });
SCRIPT;
$this->registerJs($js);
?>
<div class="lab-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
        <?php
        echo $form->field($model, 'lab_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Lab::find()->asArray()->all(), 'lab_id', 'labname'),
            'language' => 'en-gb',
            'options' => ['placeholder' => 'Select a Laboratory'],
            'pluginOptions' => [
                'allowClear' => true,
                'disabled' => true,
            ],
        ])->label('Laboratory');
        ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'labcode')->textInput(['maxlength' => true])->label('Laboratory Code') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'labcount')->textInput(['readonly'=>true])->label('Laboratory Count') ?>
        </div>
         <div class="col-md-6">
    <?= $form->field($model, 'nextrequestcode')->textInput(['maxlength' => true,'readonly'=>true])->label('Next Request Code') ?>
        </div>
     </div>
    <div class="row">
        <?php if(\Yii::$app->user->can('access-configure-template')){ ?> 
        <div class="col-md-6">
            <label class="control-label" for="RequestLaboratory">&nbsp;</label>
            <a id="CollapseRequestcode" class="btn btn-primary" data-toggle="collapse" style="width: 100%" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                Configure Request Template
            </a>
        </div>
         <?php } ?>
        <div class="col-md-6">
            <?php
                echo $form->field($model, 'active')->widget(SwitchInput::classname(), [
                    'type' => SwitchInput::CHECKBOX,
                    'pluginOptions' => [
                        'onText' => 'Active',
                        'offText' => 'Inactive',
                        'onColor' => 'success',
                        'offColor' => 'danger',
                        'handleWidth'=>110,
                    ],
               ]);
            ?>
        </div>
    </div>
    <div class="row" style="padding-bottom: 15px">
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <div class="col-md-6">
                    <label class="control-label" for="RequestLaboratory">RSTL</label>
                    <?php
                    echo Select2::widget([
                        'name' => 'RequestLaboratory',
                        'id'=>'RSTLSelect2',
                        'value' => $RequestcodedTemplate->rstl_id,
                        'data' => ArrayHelper::map(Rstl::find()->asArray()->all(), 'rstl_id', 'name'),
                        'options' => ['multiple' => false, 'placeholder' => 'Select RSTL'],
                        'pluginEvents' => [
                            "select2:select" => "function() { 
                                //Ajax Call
                                $.post('/ajax/gettemplate', {
                                    rstl_id: this.value
                                }, function(result){
                                    //Return values
                                    if(result.requestcode_template_id==0){
                                       //No Template
                                       
                                    }
                                    $('#RequestLaboratory').val(result.requestcode_template);
                                }); 
                            }
                        "]
                    ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <label class="control-label" for="RequestLaboratory">Request Template</label>
                    <input type="text" class="form-control" id="RequestLaboratory" value="<?php echo $RequestcodedTemplate->request_code_template ?>"/>
                </div>
            </div>
        </div>
    </div>
     <div style="position:absolute;right:18px;bottom:10px;">
        <?php if(\Yii::$app->user->can('access-configure-template')){ ?> 
        <button type="button" id="btnSaveRequestTemplate" style="display: none" class="btn btn-success">Save Request Template</button>
        <?php } ?>
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id'=>'btnSubmit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
    <?php ActiveForm::end(); ?>
 </div>
