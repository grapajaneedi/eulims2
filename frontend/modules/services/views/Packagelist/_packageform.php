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
                            'depends'=>['sample-name'],
                            'placeholder'=>'Select Package',
                            'url'=>Url::to(['/lab/analysis/listtest']),
                            'loadingText' => 'Loading Package...',
                        ]
                    ])
                    ?>
             </div>

             <div class="col-md-6">
             <?= $form->field($model, 'rate')->textInput(['readonly' => true]) ?>
             <?= $form->field($model, 'rstl_id')->hiddenInput()->label(false) ?>
            
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
