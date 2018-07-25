<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\lab\Lab;
use common\models\services\Testcategory;
use common\models\services\Sampletype;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;
use common\models\services\Test;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Packagelist */
/* @var $form yii\widgets\ActiveForm */

$Testcategorylist= ArrayHelper::map(Testcategory::find()->all(),'testcategory_id','category_name');
$Sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sample_type_id','sample_type');

$js=<<<SCRIPT
$(".kv-row-checkbox").click(function(){
   
   var keys = $('#sample-grid').yiiGridView('getSelectedRows');
   var keylist= keys.join();
   $("#sample_ids").val(keylist);
  // $("#sample-testcategory_id").prop('disabled', false);
   
});    
$(".select-on-check-all").change(function(){

 var keys = $('#sample-grid').yiiGridView('getSelectedRows');
 var keylist= keys.join();
  $("#sample_ids").val(keylist);
 // $("#sample-testcategory_id").prop('disabled', false);
 
});

SCRIPT;
$this->registerJs($js);


?>



<div class="packagelist-form" style="padding-bottom: 10px">

    <?php $form = ActiveForm::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $sampleDataProvider,
        //'filterModel' => $samplesearchmodel,
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

         <div class="row">
         <div class="col-sm-6">
         <?= $form->field($model,'testcategory_id')->widget(Select2::classname(),[
                         'data' => $testcategory,
                         'theme' => Select2::THEME_KRAJEE,
                      //   'disabled'=>true,
                         //'theme' => Select2::THEME_BOOTSTRAP,
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
             <div class="col-md-6">
             <?php
            // $form->field($model, 'tests')->textInput(['maxlength' => true])
              ?>

            <?= $form->field($model, 'name')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data'=>$test,
                        'options'=>['id'=>'sample-name'],
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['sample-sample_type_id'],
                            'placeholder'=>'Select Package',
                            'url'=>Url::to(['/services/packagelist/listpackage']),
                            'loadingText' => 'Loading Package...',
                        ]
                    ])
                    ?>
             </div>

             <div class="col-md-6">
             <?= $form->field($model, 'rate')->textInput(['readonly' => true]) ?>
             <?= $form->field($model, 'rstl_id')->hiddenInput(['value'=> 1])->label(false) ?>

             <?= Html::textInput('sample_ids', '', ['class' => 'form-control', 'id'=>'sample_ids',  'type'=>"hidden"], ['readonly' => true]) ?>
            
             </div>
         </div>

         <?= $form->field($model, 'tests')->textarea(['rows' => 4, 'readonly' => true]) ?>
            <div class="row" style="float: right;padding-right: 30px">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?php if($model->isNewRecord){ ?>
                <?php } ?>
            <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
            </div>
    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("$('#sample-name').on('change',function(){
    var id = $('#sample-name').val();
        $.ajax({
            url: '".Url::toRoute("packagelist/getpackage")."',
            dataType: 'json',
            method: 'GET',
            //data: {id: $(this).val()},
            data: {packagelist_id: id},
            success: function (data, textStatus, jqXHR) {
                $('#packagelist-rate').val(data.rate);
                $('#packagelist-tests').val(data.tests);
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
