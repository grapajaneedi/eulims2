<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\finance\Collectiontype;
use common\models\finance\Paymentmode;
use common\models\lab\Customer;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Orderofpayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orderofpayment-form" style="margin:0important;padding:0px!important;padding-bottom: 10px!important;">

    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($model, 'RequestIds')->textInput() ?>
    <div style="padding:0px!important;">
        <div class="row">
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
            <div class="col-sm-6">
             <?php
             echo $form->field($model, 'order_date')->widget(DatePicker::classname(), [
             'options' => ['placeholder' => 'Select Date ...'],
             'type' => DatePicker::TYPE_COMPONENT_APPEND,
                 'pluginOptions' => [
                     'format' => 'yyyy-mm-dd',
                     'todayHighlight' => true,
                     'autoclose'=>true
                 ]
             ]);
             ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
            <?php
                echo $form->field($model, 'customer_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Customer::find()->all(), 'customer_id', 'customer_name'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select a customer ...'],
                'pluginOptions' => [
                  'allowClear' => true,
                  'autoclose'=>false
                ],
                'pluginEvents' => [
                    "change" => "function(e) {
                         e.preventDefault();
                        var customer_id=$(this).val();
                        $('#prog').show();
                        $('#requests').hide();
                        jQuery.ajax( {
                            type: \"POST\",
                            //data: {
                            //    customer_id:customer_id,
                           // },
                            url: \"/finance/orderofpayment/getlistrequest?id=\"+$(this).val(),
                            dataType: \"html\",
                            success: function ( response ) {

                               setTimeout(function(){
                               $('#prog').hide();
                                 $('#requests').show();
                               $('#requests').html(response);
                                   }, 0);


                            },
                            error: function ( xhr, ajaxOptions, thrownError ) {
                                alert( thrownError );
                            }
                        });  
                        $(this).select2('open');
                      //  $(this).one('select-focus',select2Focus);
                      $(this).attr('tabIndex',1);
                     }",
                 ], 
                ]);
             ?>
            </div>
             <div class="col-sm-6">
            <?php
                echo $form->field($model, 'payment_mode_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Paymentmode::find()->all(), 'payment_mode_id', 'payment_mode'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select Payment Mode ...'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
                ]);
             ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">  
                 <div id="prog" style="position:relative;display:none;">
                    <img style="display:block; margin:0 auto;" src="<?php echo  $GLOBALS['frontend_base_uri']; ?>/images/ajax-loader.gif">
                     </div>
                <div id="requests" style="padding:0px!important;">    	
                   <?php //echo $this->renderAjax('_request', ['dataProvider'=>$dataProvider]); ?>
                </div> 
            </div>
        </div> 
        <div class="row">
            <div class="col-lg-12"> 
                <?= $form->field($model, 'purpose')->textarea(['maxlength' => true]); ?>
            </div>
        </div>



        <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if(Yii::$app->request->isAjax){ ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <?php } ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<style>
    .modal-body{
        padding-top: 0px!important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('#orderofpayment-customer_id').click();
    });
    $('#orderofpayment-customer_id').on('change',function() {
       $(this).select2('close');
        //alert('csdfsd');
    });
  
  
</script>
