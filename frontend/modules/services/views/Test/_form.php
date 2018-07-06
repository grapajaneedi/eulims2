<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;
use common\models\services\Testcategory;
use common\models\services\Sampletype;
use kartik\widgets\DepDrop;


/* @var $this yii\web\View */
/* @var $model common\models\services\Test */
/* @var $form yii\widgets\ActiveForm */

$Testcategorylist= ArrayHelper::map(Testcategory::find()->all(),'testcategory_id','category_name');
$Sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sample_type_id','sample_type');
$LabList= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');

?>

<div class="test-form" style="padding-bottom: 10px">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
             <div class="col-md-6">
                 <?= $form->field($model, 'testname')->textInput(['maxlength' => true]) ?>
             </div>
             <div class="col-md-6">
                 <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>
             </div>
         </div>

         <div class="row">
             <div class="col-md-6">
                 <?= $form->field($model, 'payment_references')->textInput(['maxlength' => true]) ?>
             </div>
             <div class="col-md-6">
                 <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>
             </div>
         </div>

         <div class="row">
             <div class="col-md-6">
                <?= $form->field($model, 'lab_id')->widget(Select2::classname(), [
                                'data' => $LabList,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select Lab'],
                                'pluginOptions' => [
                                'allowClear' => true
                                ],
                        ])->label("Lab"); ?>
            </div>

            <div class="col-md-6">    
            <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>
           
            </div>
        </div>

        <div class="row">
             <div class="col-md-6">
                    <?= $form->field($model,'testcategory_id')->widget(Select2::classname(),[
                                'data' => $testcategory,
                                'theme' => Select2::THEME_KRAJEE,
                                'options' => ['id'=>'sample-testcategory_id'],
                                'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Test category'],
                        ])
                    ?>
            </div>

            <div class="col-md-6">    

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
         <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if(Yii::$app->request->isAjax){ ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <?php } ?> 
         </div>
    <?php ActiveForm::end(); ?>

</div>
