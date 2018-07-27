<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\lab\Request;
use common\models\system\Profile;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Cancelledrequest */
/* @var $form yii\widgets\ActiveForm */
$disabled=false;
$Request=  Request::find()->where(['request_id'=>$Req_id])->one();
$model->request_ref_num=$Request->request_ref_num;
$model->request_id=$Request->request_id;
$model->cancelledby= Yii::$app->user->id;
// Query Profile Name
$Profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
$UserCancell=$Profile->fullname;
if($HasOP){// Request is with order of payment already
  $disabled=true;
}else{
  $disabled=false;
}
?>
<div class="cancelledrequest-form">
    <?php if($HasOP){ ?>
    <div id="cannotcancel" style="width: 470px;position: absolute;height: 330px;left: 15px;top:0px;">
        <span class="badge badge-important" style="background-color: red;margin-top: 25%;margin-left: 45px;padding-top: 40px;padding-bottom: 30px;padding-top: 30px">
            <i class="fa fa-warning" style='font-size: 14px'></i><br>
            Warning: This Request with Reference # '<?= $model->request_ref_num ?>'<br> 
            already contained an Order of Payment,<br>hence cancellation is prohibited!</span>
    </div>
    <?php } ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'request_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'cancelledby')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'request_ref_num')->textInput(['maxlength' => true,'readonly'=>true])->label("Request Reference #") ?>

    <?= $form->field($model, 'cancel_date')->textInput(['readonly'=>true])->label('Date') ?>
    
    <?= $form->field($model, 'reason')->textarea(['style'=>'overflow-y: scroll']) ?>
    <label class="control-label" for="Cancelled By">Cancelled By:</label>                     
    <?= Html::tag('text',$UserCancell,['class'=>'form-control','readonly'=>true]) ?>
    <div class="row" style="float: right;padding-right: 15px;padding-top: 10px;margin-bottom: 10px">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['disabled'=>$disabled,'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if($model->isNewRecord){ ?>
        <?= Html::resetButton('Reset', ['disabled'=>$disabled,'class' => 'btn btn-danger']) ?>
        <?php } ?>
        <?= Html::Button('Close', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
    <br>
    <?php ActiveForm::end(); ?>
</div>
