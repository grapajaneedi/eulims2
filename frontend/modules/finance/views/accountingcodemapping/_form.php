<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Accountingcodemapping */
/* @var $form yii\widgets\ActiveForm */

//var_dump($dataProviderAccountCollection);
?>

<div class="accountingcodemapping-form">
<?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'accountingcode_id')->widget(Select2::classname(), [
                'data' => $dataProviderAccountCode,
                'options' => ['placeholder' => 'Select Accounting Code'],
                'attribute' => 'accountcode',
                'theme' => Select2::THEME_BOOTSTRAP,
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '200px', 
                    'class' => '.col-md-6'
                ],
            ]);
            ?>


        </div>
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'collectiontype_id')->widget(Select2::classname(), [
                'data' => $dataProviderCollectionType,
                'options' => ['placeholder' => 'Select Accounting Code'],
                'attribute' => 'collectiontype_id',
                'theme' => Select2::THEME_BOOTSTRAP,
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '250px',
                    'class' => 'col-md-6'
                ],
            ]);
            ?>

        </div>
    </div>



    <div class="form-group">
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>


    </div>

        <?=
        GridView::widget([
            'dataProvider' => $dataProviderAccountCollection,
            //'filterModel' => $modelCollectionType,
            'columns' => [
                'accountcode',
                'natureofcollection',
            ],
        ]);
        ?> 



    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
