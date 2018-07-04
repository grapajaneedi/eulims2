<?php
use kartik\grid\GridView;
/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 06 29, 18 , 3:17:41 PM * 
 * Module: _opgrid * 
 */

/**
 * Description of _bigrid
 *
 * @author OneLab
 */
$js=<<<SCRIPT
    function getKeys(){
        var dkeys=$("#BIGrid").yiiGridView("getSelectedRows");
        $("#soa-bi_ids").val(dkeys);
        var SearchFieldsTable = $(".kv-grid-table>tbody");
        var trows = SearchFieldsTable[0].rows;
        var Total=0.00;
        var amt=0.00;
        $.each(trows, function (index, row) {
            var data_key=$(row).attr("data-key");
            for (i = 0; i < dkeys.length; i++) { 
                if(data_key==dkeys[i]){
                    amt=StringToFloat(trows[index].cells[5].innerHTML);
                    Total=Total+parseFloat(amt);
                }
            }
        }); 
        $("#soa-current_amount-disp").val(Total);
        $("#soa-current_amount").val(Total);
        $("#soa-current_amount-disp").maskMoney('mask', Total);
    }
    
    $(".kv-row-checkbox").change(function(){
       getKeys();
    });   
    $(".select-on-check-all").change(function(){
       getKeys();
    });     
        
SCRIPT;
$this->registerJs($js);

echo GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'BIGrid',
        'pjax'=>true,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        'containerOptions'=>['style'=>'overflow: auto;height: 200px'],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'toolbar'=>[],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
               // 'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
               'footer'=>false   
            ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'class'=>'kartik\grid\CheckboxColumn',
            ],
            [
                'attribute'=>'invoice_number',
                'label'=>'BI #',
                'hAlign' => 'center',
            ],
            [
                'attribute'=>'billing_date',
                'hAlign' => 'center',
            ],
            [
                'attribute'=>'due_date',
                'hAlign' => 'center',
            ],
            [
                'attribute'=>'amount',
                'hAlign' => 'right',
                'contentOptions' => ['class' => 'bi-amount'],
                'label'=>'Amount',
                'value'=>function($model){
                    return number_format($model->amount,2);
                }
            ],
        ],
    ]); 
            
?>