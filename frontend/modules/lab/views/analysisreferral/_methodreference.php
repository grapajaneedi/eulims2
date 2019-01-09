<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="analysismethodreference-form">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
            <?php
                $gridColumns = [
                    [
                        'class' => '\kartik\grid\SerialColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:20px;'],
                    ],
                    [
                        'class' =>  '\kartik\grid\RadioColumn',
                        'radioOptions' => function ($model) {
                            return [
                                'value' => $model['methodreference_id'],
                                //'name' => 'methodref_id',
                                //'checked' => $model['testname_method_id'] == 2
                                //'onclick' => "checkMethodref(".$model['methodreference_id'].")",
                                //'onclick' => "checkMethodref()",
                            ];
                        },
                        'name' => 'methodref_id',
                        'showClear' => true,
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:20px;'],
                    ],
                    /*[
                        'class' => 'yii\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'multiple'=>false,

                    ],*/
                    /*[
                        'attribute'=>'testname_method_id',
                        'enableSorting' => false,
                    ],*/
                    /*[
                        'attribute'=>'methodreference_id',
                        'enableSorting' => false,
                    ],*/
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Method',
                        'enableSorting' => false,
                        'value' => function($data){
                            return $data['methodreference']['method'];
                        },
                        'contentOptions' => [
                            'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Reference',
                        'enableSorting' => false,
                        'value' => function($data){
                            return $data['methodreference']['reference'];
                        },
                        'contentOptions' => [
                            'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Fee',
                        'enableSorting' => false,
                        'value' => function($data){
                            return number_format($data['methodreference']['fee'],2);
                        },
                        'contentOptions' => [
                            'style'=>'text-align:right;max-width:45px;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                ];

                echo GridView::widget([
                    'id' => 'method-reference-grid',
                    'dataProvider'=> $methodProvider,
                    //'pjax'=>false,
                    'pjax'=>true,
                    //'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                    //'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                    'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                        ]
                    ],
                    'containerOptions'=>[
                        'style'=>'overflow:auto; height:200px',
                    ],
                    'floatHeaderOptions' => ['scrollingTop' => true],
                    'responsive'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'bordered' => true,
                    'panel' => [
                       'heading'=>'<h3 class="panel-title">Method Reference</h3>',
                       'type'=>'primary',
                       'before' => '',
                       'after'=>false,
                       //'footer'=>false,
                    ],
                    'columns' => $gridColumns,
                    'toolbar' => false,
                ]);
            ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

//function checkMethodref(methodreferenceId){
//    var $grid = $('#method-reference-grid'); // your grid identifier 
    //var getVal = "";
    //$grid.on('grid.radiochecked', function(ev, key, val) {
        //alert("Key = " + key + ", Val = " + val);
        //getVal.val(val);
    //});

//    alert(methodreferenceId);
    //alert($grid.on('grid.radiochecked').val());
    /*$grid.on('grid.radiocleared', function(ev, key, val) {
        alert("Key = " + key + ", Val = " + val);
    });*/
//}
</script>