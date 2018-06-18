<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use common\models\finance\Project;
use common\models\finance\Paymentmode;
use common\models\finance\Collectiontype;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Receipt */
/* @var $form yii\widgets\ActiveForm */
$paymentlist='';
?>

<div class="receipt-form" style="margin:0important;padding:0px!important;padding-bottom: 10px!important;">

    <?php $form = ActiveForm::begin(); ?>
    <div class="alert alert-info" style="background: #d9edf7 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d">Fields with <i class="fa fa-asterisk text-danger"></i> are required.</p>
     
    </div>
   
    <div style="padding:0px!important;">
        <div class="row">
            <div class="col-sm-6">
           <?php 

                echo $form->field($model, 'project_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Project::find()->all(), 'project_id', 'project'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Please Select ...'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
                ]);
            ?>
            </div>   
            <div class="col-sm-6">
             <?php
             echo $form->field($model, 'receiptDate')->widget(DatePicker::classname(), [
             'options' => ['placeholder' => 'Select Date ...',
             'autocomplete'=>'off'],
             'type' => DatePicker::TYPE_COMPONENT_APPEND,
                 'pluginOptions' => [
                     'format' => 'yyyy-mm-dd',
                     'todayHighlight' => true,
                     'autoclose'=>true,   
                 ]
             ]);
             ?>
            </div>
        </div>
        <div class="row">
          
             <div class="col-sm-6">
                <?= $form->field($model, 'payment_mode_id')->widget(Select2::classname(), [
                    'pluginOptions'=>[
                        'depends'=>['op-customer_id'],
                        'placeholder'=>'Select Payment Mode',
                        'url'=>Url::to(['/finance/op/listpaymentmode?customerid='.$model->customer_id]),
                        'allowClear' => true
                    ]
                ])
                ?>
            </div>
            <div class="col-sm-6">
           <?php 

                echo $form->field($model, 'collectiontype_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Collectiontype::find()->all(), 'collectiontype_id', 'natureofcollection'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select Collection Type ...'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
                ]);
            ?>
            </div>  
        </div>
       
    </div>
    <?php ActiveForm::end(); ?>

</div>
<style>
    .modal-body{
        padding-top: 0px!important;
    }
</style>
