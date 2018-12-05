<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use kartik\select2\Select2;
use kartik\checkbox\CheckboxX;
//use kartik\grid\GridView;
//use bs\dbManager\models\BaseDumpManager;

/* @var $this yii\web\View */
$this->title = Yii::t('dbManager', 'DB Manager');
$this->params['breadcrumbs'][] = $this->title;

$config= Yii::$app->components;
/*echo "<pre>";
var_dump($config);
echo "</pre>";
var_dump($config);
*/
$form = ActiveForm::begin([
    'action'=>'/dbmanager/default/create-backup',
    'options' => [
        'id' => 'frmBackup',
        'method'=>'GET'
    ] // important
]);
$dbComponents= \Yii::$app->components;
$dbList=$dbComponents['backup']['databases'];
$dbs=[
    'all'=>'All Databases',
];
var_dump($dbList);
/*$dbs=[
    'all'=>'All Databases',
    'eulims'=>'eulims',
    'eulims_lab'=>'eulims lab',
    'eulims_inventory'=>'eulims inventory',
    'eulims_finance'=>'eulims finance',
    'eulims_address'=>'eulims address',
    'eulims_referral_lab'=>'eulims referral lab'
];
 * 
 */
$ext=[
    'tar'=>'Tape Archive (*.tar)',
    'zip'=>'Winzip (*.zip)',
    'gz'=>'Gzip (*.gz)',
    'rar'=>'Winrar(*.rar)'
];
?>
<div class="panel panel-primary">
    <div class="panel-heading">Database Manager</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <?=
                $form->field($model, 'extension')->widget(Select2::classname(), [
                    'data' => $ext,
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select Extension'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-3">
                <label class="control-label" for="backupmodel-extension">Backup Database</label>
                <?=
                $form->field($model, 'backupdatabase')->widget(CheckboxX::class, [
                    'options'=>['id'=>'backupdatabase'],
                    'pluginOptions'=>['threeState'=>false],
                    'pluginEvents'=>[
                        "change"=>"function() { 
                            $('#backupmodel-database').prop('disabled', this.value==0 ? true : false);
                        }    
                    "
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="col-md-3">
                <?=
                $form->field($model, 'database')->widget(Select2::classname(), [
                    'data' => $dbs,
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select Database'],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label class="control-label" for="backupmodel-extension">Backup Images and Photos</label>
                <?=
                $form->field($model, 'backupfiles')->widget(CheckboxX::class, [
                    'options'=>['id'=>'backupfiles'],
                    'pluginOptions'=>['threeState'=>false],
                    'pluginEvents'=>[
                        "change"=>"function() { 
                            //$('#backupmodel-database').prop('disabled', this.value==0 ? true : false);
                        }    
                    "
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="col-md-3">
                <label class="control-label" for="backupmodel-extension">Auto Download</label>
                <?=
                $form->field($model, 'download')->widget(CheckboxX::class, [
                    'options'=>['id'=>'download'],
                    'pluginOptions'=>['threeState'=>false],
                    'pluginEvents'=>[
                        "change"=>"function() { 
                            //$('#backupmodel-database').prop('disabled', this.value==0 ? true : false);
                        }    
                    "
                    ],
                ])->label(false);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="padding-right: 15px">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                <button style='margin-left: 5px' type='button' class='btn btn-secondary pull-left-sm' data-dismiss='modal'>Cancel</button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
