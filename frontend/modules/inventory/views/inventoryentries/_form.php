<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Functions;
use kartik\widgets\FileInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\InventoryEntries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-entries-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">

    <div class="row">
        <div class="col-md-6">
            <?php
            $func=new Functions();
            echo $func->GetProductList($form,$model,false,"Product");
            ?> 
            
            <?= $form->field($model, 'po_number')->textInput(['maxlength' => true]) ?>
            
             <?php
                 echo "<b>Manufacturing Date</b>";
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'manufacturing_date',
                    'readonly' => true,
                    'options' => ['placeholder' => 'Enter Date'],
                    'value' => function($model) {
                        return date("m/d/Y", $model->manufacturing_date);
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
            <br>

            <?php
                echo "<b>Expiration Date</b>";
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'expiration_date',
                    'readonly' => true,
                    'options' => ['placeholder' => 'Enter Date'],
                    'value' => function($model) {
                        return date("m/d/Y", $model->expiration_date);
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
        <div class="col-md-6">
             <?php
                echo $func->GetSupplierList($form,$model,false,"Supplier");
            ?> 
            
            <?= $form->field($model, 'quantity')->textInput() ?>

            <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'total_amount')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
        <?php // your fileinput widget for single file upload
            echo $form->field($model, 'Image1')->widget(FileInput::classname(), [
                'options'=>[
                    'id'=>'profileImage_upload',
                    'accept'=>'image/*'
                ],
                'pluginOptions'=>[
                    'allowedFileExtensions'=>['jpg','gif','png'],
                    'overwriteInitial'=>true,
                    'resizeImages'=>true,
                    'initialPreviewConfig'=>[
                        'width'=>'120px',
                    ],
                    'initialPreview' => [
                        '<img src="/uploads/img.png" width="200" class="file-preview-image">',
                    ],
                    'showUpload'=>false,
                    'showRemove'=>false,
                    'showBrowse'=>true,
                   // 'showText'=>false
                ],
            ])->label(false);
        ?>    
        </div>
      
     </div>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
