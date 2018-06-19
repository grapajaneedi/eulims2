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
?>

<div class="cancelledrequest-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'request_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'cancelledby')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'request_ref_num')->textInput(['maxlength' => true,'readonly'=>true])->label("Request Reference #") ?>

    <?= $form->field($model, 'cancel_date')->textInput(['readonly'=>true])->label('Date') ?>
    
    <?= $form->field($model, 'reason')->textarea(['style'=>'overflow-y: scroll']) ?>
    <label class="control-label" for="Cancelled By">Cancelled By:</label>                     
    <?= Html::tag('text',$UserCancell,['class'=>'form-control','readonly'=>true]) ?>

    <div class="row">
        <div class="row" style="float: right;padding-right: 30px;padding-top: 10px">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['disabled'=>$disabled,'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if($model->isNewRecord){ ?>
            <?= Html::resetButton('Reset', ['disabled'=>$disabled,'class' => 'btn btn-danger']) ?>
            <?php } ?>
            <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
