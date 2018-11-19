<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\inventory\Categorytype;
use common\models\inventory\Suppliers;
use common\models\inventory\Producttype;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model common\models\inventory\Products */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'InventoryEntries', 
        'relID' => 'inventory-entries', 
        'value' => \yii\helpers\Json::encode($model->inventoryEntries),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'InventoryWithdrawaldetails', 
        'relID' => 'inventory-withdrawaldetails', 
        'value' => \yii\helpers\Json::encode($model->inventoryWithdrawaldetails),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>
     <?= $form->field($model, 'product_id')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-md-6">
        <?php // your fileinput widget for single file upload
            echo "<b>Image 1 </b>";
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
        <div class="col-md-6">
        <?php // your fileinput widget for single file upload
            echo "<b>Image 2 </b>";
            echo $form->field($model, 'Image2')->widget(FileInput::classname(), [
                'options'=>[
                    'id'=>'profileImage2_upload',
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
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'product_code')->textInput(['maxlength' => true, 'placeholder' => 'Product Code']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'product_name')->textInput(['maxlength' => true, 'placeholder' => 'Product Name']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'srp')->textInput(['maxlength' => true, 'placeholder' => 'Srp']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'placeholder' => 'Price']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
             <?= $form->field($model, 'qty_min_reorder')->textInput(['placeholder' => 'Qty Min Reorder']) ?>
        </div>
        <div class="col-sm-6">
            <?=
            $form->field($model, 'categorytype_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => ArrayHelper::map(Categorytype::find()->orderBy('categorytype')->asArray()->all(), 'categorytype_id', 'categorytype'),
                'options' => ['placeholder' => 'Choose CategoryType'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'qty_reorder')->textInput(['placeholder' => 'Qty Reorder']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'qty_onhand')->textInput(['placeholder' => 'Qty Onhand']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
             <?= $form->field($model, 'discontinued')->checkbox() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'qty_per_unit')->textInput(['maxlength' => true, 'placeholder' => 'Qty Per Unit']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-sm-6">
            <?=
            $form->field($model, 'suppliers_ids')->widget(\kartik\widgets\Select2::classname(), [
                'data' => ArrayHelper::map(Suppliers::find()->orderBy('suppliers')->asArray()->all(), 'suppliers_id', 'suppliers'),
                'options' => ['placeholder' => 'Choose Suppliers','multiple'=>true],
                'pluginOptions' => [
                    'allowClear' => true,
                    "change" => "function() { 
                        $('#suppliers_ids').val($(this).val());
                    }
                    ",
                ],
            ]);
            ?>
            <?=
            $form->field($model, 'producttype_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => ArrayHelper::map(Producttype::find()->orderBy('producttype')->asArray()->all(), 'producttype_id', 'producttype'),
                'options' => ['placeholder' => 'Choose Product Type'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Product Type');
            ?>
        </div>
    </div>
    <div class="row">
         <div class="col-md-6">
        <?= $form->field($model, 'created_by')->hiddenInput()->label(false) ?>
        </div>
        <div class="col-sm-6">
            
        </div>
    </div>
    
    
    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
