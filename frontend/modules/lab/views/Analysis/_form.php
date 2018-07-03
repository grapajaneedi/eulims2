<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
use common\models\services\Test;
use common\models\services\Sampletype;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */


$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
      
      var keys = $('#sample-grid').yiiGridView('getSelectedRows');
      var keylist= keys.join();
      $("#sample_ids").val(keylist);
      
   });    
   $(".select-on-check-all").change(function(){

    var keys = $('#sample-grid').yiiGridView('getSelectedRows');
    var keylist= keys.join();
     $("#sample_ids").val(keylist);
    
   });
  
SCRIPT;
$this->registerJs($js);
?>


<div class="analysis-form">

    <?php $form = ActiveForm::begin(); ?>
 

    <?= GridView::widget([
        'dataProvider' => $sampleDataProvider,
        'pjax'=>true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'bordered' => true,
        'id'=>'sample-grid',
        'striped' => true,
        'condensed' => true,
        'responsive'=>false,
        'containerOptions'=>[
            'style'=>'overflow:auto; height:180px',
        ],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'floatHeaderOptions' => ['scrollingTop' => true],
        'columns' => [
               [
            'class' => '\kartik\grid\CheckboxColumn',
         ],
            'samplename',
            [
                'attribute'=>'description',
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function($data){
                    return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".$data->sampling_date."</b></span>,&nbsp;".$data->description : $data->description;
                },
                'contentOptions' => ['style' => 'width:70%; white-space: normal;'],
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'rstl_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'pstcanalysis_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'request_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'sample_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'sample_code')->hiddenInput(['maxlength' => true])->label(false)?>

    <?= $form->field($model, 'testname')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'cancelled')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'is_package')->hiddenInput()->label(false)  ?>

    <?= Html::textInput('sample_ids', '', ['class' => 'form-control', 'id'=>'sample_ids', 'type'=>"hidden"], ['readonly' => true]) ?>

        <div class="row">
        <div class="col-sm-6">
        <?= $form->field($model,'testcategory_id')->widget(Select2::classname(),[
                        'data' => $testcategory,
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['id'=>'sample-testcategory_id'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Test category'],
                ])
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'sample_type_id')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'data'=>$sampletype,
                'options'=>['id'=>'sample-sample_type_id'],
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['sample-testcategory_id'],
                    'placeholder'=>'Select Sample type',
                    'url'=>Url::to(['/lab/sample/listsampletype']),
                    'loadingText' => 'Loading Sampletype...',
                ]
            ])
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">

        <?= $form->field($model, 'test_id')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'data'=>$test,
                'options'=>['id'=>'sample-test_id'],
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['sample-sample_type_id'],
                    'placeholder'=>'Select Test',
                    'url'=>Url::to(['/lab/analysis/listtest']),
                    'loadingText' => 'Loading Test...',
                ]
            ])
            ?>
        </div>
           <div class="col-sm-6">
        <?= $form->field($model, 'method')->textInput(['readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
              <?= $form->field($model, 'references')->textInput(['readonly' => true]) ?>
        </div>
           <div class="col-sm-6">
           <?= $form->field($model, 'quantity')->textInput(['readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
              <?= $form->field($model, 'fee')->textInput(['readonly' => true]) ?>
        </div>
           <div class="col-sm-6">

           <label class="control-label">Analysis Date</label>
                <?php echo DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'date_analysis',
                'readonly'=>true,
                'options' => ['placeholder' => 'Enter Date'],
                    'value'=>function($model){
                        return date("m/d/Y h:i:s P",$model->date_analysis);
                    },
                'pluginOptions' => [
                        'format' => 'yyyy-mm-dd h:i:s'
                ],
                ]); ?>
        </div>
    </div>


    <div class="row" style="float: right;padding-right: 30px">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if($model->isNewRecord){ ?>
        <?php } ?>
    <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>

   

    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs("$('#sample-test_id').on('change',function(){
    var id = $('#sample-test_id').val();
        $.ajax({
            //url: '".Url::toRoute("sample/getlisttemplate")."',
            url: '".Url::toRoute("analysis/gettest")."',
            dataType: 'json',
            method: 'GET',
            //data: {id: $(this).val()},
            data: {test_id: id},
            success: function (data, textStatus, jqXHR) {
                $('#analysis-method').val(data.method);
                $('#analysis-references').val(data.references);
                $('#analysis-fee').val(data.fee);
                $('#analysis-quantity').val('1');
                $('.image-loader').removeClass( \"img-loader\" );
            },
            beforeSend: function (xhr) {
                //alert('Please wait...');
                $('.image-loader').addClass( \"img-loader\" );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('An error occured!');
                alert('Error in ajax request');
            }
        });
});");
?>

<script type="text/javascript">
    function settotal(){
        var keys = $('#sample-grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
      //  $("#op-requestids").val(keys.join());
        $.post({
            url: '/finance/op/calculate-total?id='+keylist, // your controller action
            success: function(data) {
                // var tot=parseFloat(data);
                // var total=CurrencyFormat(tot,2);
                // $('#total').html(total);
                //  var payment_mode=$('#op-payment_mode_id').val()
                // if(payment_mode===4){
                //     wallet=parseInt($('#wallet').val());
                //     totalVal = parseFloat($('#total').html().replace(/[^0-9-.]/g, ''));
                   
                //     if( totalVal > wallet) {
                       
                //        swal("Insufficient customer wallet");
                //       $('#op-purpose').prop('disabled', true);
                //       $('#createOP').prop('disabled', true);
                    
                //     }
                //     else{
                //         if(total !== 0){
                //             $('#op-purpose').prop('disabled', false);
                //             $('#createOP').prop('disabled', false);
                //         }
                       
                //     }
                // }
            }
        });
    }
    
</script>