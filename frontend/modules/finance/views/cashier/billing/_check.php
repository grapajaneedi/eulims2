<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\money\MaskMoney;
use kartik\widgets\DatePicker;
/* 
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 07 11, 18 , 2:55:03 PM * 
 * Module: _check * 
 */

/* @var $this yii\web\View */
$js=<<<SCRIPT
   $("#btnAddBankDetails").click(function(){
        InsertRow();
   });  
   function ClearDetails(){
      $("#bank_name").val("");
      $("#checknumber").val("");
      $("#check_amount-disp").maskMoney('mask', 0.00);
      $("#check_amount-disp").val(0.00);
      $("#check_amount-disp").val(0);
   }
   function InsertRow(){
      var table = document.getElementById("checkTable");
      var totalRows=document.getElementById("checkTable").rows.length;
      var row = table.insertRow(totalRows-1);
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
      var cell4 = row.insertCell(3);
      var cell5 = row.insertCell(4);
      cell1.setAttribute("class", "kv-align-center");
      cell1.innerHTML = "";
      cell2.innerHTML = $("#bank_name").val();
      cell3.setAttribute("class", "kv-align-center");
      cell3.innerHTML = $("#checknumber").val();
      cell4.setAttribute("class", "kv-align-center");
      cell4.innerHTML = $("#checkdate").val(); //
      cell5.setAttribute("class", "kv-align-right");
      cell5.innerHTML = $("#check_amount").val();//
      ClearDetails()
   }
SCRIPT;
$this->registerJs($js);
$gridColumns=[
    [
        'attribute'=>'receipt_id',
        'label'=>'ReceiptID',
        'width'=>'20px'
    ],
    'bank',
    [
        'attribute'=>'checknumber',
        'label'=>'Check #',
        'hAlign'=>'center'
    ],
    [
        'attribute'=>'checkdate',
        'label'=>'Check Date',
        'hAlign'=>'center'
    ],
    [
        'attribute'=>'amount',
        'label'=>'Amount',
        'hAlign'=>'right'
    ]
];
echo GridView::widget([
    'id' => 'kv-grid-checktable',
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'tableOptions'=>['id'=>'checkTable'],
    'pjax' => true, // pjax is set to always true for this demo
    // set your toolbar
    'toolbar' =>  [
       
    ],
    // set export properties
    'export' => [
        'fontAwesome' => true
    ],
    // parameters from the demo form
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode("Check Details"),
        'before'=>Html::button("Add Bank Details",['class'=>'btn btn-primary','onclick'=>'$("#BankDetails").show()'])
    ],
    'persistResize' => false,
    'toggleDataOptions' => ['minCount' => 10],
    
]);
?>
<div id="BankDetails" class="panel panel-primary col-md-10" style="position: fixed; top: 340px;display: none">
    <div class="panel-heading">Add Bank Details <button type="button" style="float: right" class="close" onclick="$('#BankDetails').hide()" aria-hidden="true">×</button></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <label class="control-label" for="bank_name">Bank Name</label>
                <input id="bank_name" type="text" placeholder="Enter Bank Name" class="form-control" />
            </div>
            <div class="col-sm-6">
                <label class="control-label" for="checknumber">Check #</label>
                <input id="checknumber" type="text" placeholder="Enter Check #" class="form-control" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label class="control-label" for="checkdate">Check Date</label>
                <?php
                echo DatePicker::widget([
                    'name' => 'checkdate',
                    'id'=>'checkdate',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'value' => date("Y-m-d"),
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose'=>true,  
                    ]
                ]);
                ?>
            </div>
            <div class="col-sm-6">
                <label class="control-label" for="amount">Amount</label>
                <?php
                   echo MaskMoney::widget([
                    'name' => 'amount',
                    'id'=>'check_amount',
                    'value' => 0.00,
                    'pluginOptions' => [
                        'prefix' => '₱ ',
                        'thousands' => ',',
                        'decimal' => '.',
                        'precision' => 2
                    ],
                ]);

                ?>
            </div>
        </div>
        <div class="row" style="padding-top: 15px;background-color: white">
            <div class="col-md-12 pull-right">
                <button id="btnCheckClose" type="button" onclick="$('#BankDetails').hide()" class="btn btn-default pull-right">Close</button>
                <button id="btnAddBankDetails" type="button" class="btn btn-primary pull-right" style="padding-right: 20px"><i class="fa fa-save"> </i> Add Bank Details</button>
            </div>
        </div>
    </div>
</div>