<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use frontend\modules\finance\components\models\Ext_Request;
use common\models\lab\Request;
use common\components\Functions;
use kartik\widgets\DatePicker;
use \yii\helpers\ArrayHelper;
use common\models\lab\Customer;
$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
        settotal();
   });    
   $(".select-on-check-all").change(function(){
        settotal();
   });
  
SCRIPT;
$this->registerJs($js);
$func=new Functions();
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'RequestGrid',
        'filterModel' => $searchModel,
        'containerOptions' => ['style' => 'overflow-x: none!important','class'=>'kv-grid-container'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-book"></i>  Request',
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'request_ref_num',
            [
                'label'=>'Request Date',
                'attribute'=>'request_datetime',
                'value'=>function($model){
                    //return date('d/m/Y H:i:s',strtotime($model->request_datetime));
                    return ($model->request_type_id == 2 && $model->request_datetime == '0000-00-00 00:00:00') ? null : date('d/m/Y H:i:s',strtotime($model->request_datetime));
                },
                'filter'=>DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'request_datetime',
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'options' => ['placeholder' => 'Select date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]),
            ],
            [
                'attribute' => 'customer_id', 
                'label'=>'Customer',
                'vAlign' => 'middle',
                'width' => '180px',
               
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->customer ? $model->customer->customer_name : "";
                },
                //'group'=>true,  // enable grouping
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Customer::find()->orderBy('customer_name')->asArray()->all(), 'customer_id', 'customer_name'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Customer'],
               
                'format' => 'raw',
                'noWrap' => false,
                'mergeHeader'=>true,
                'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],
            ],      
            [
                'label'=>'Total',
                'attribute'=>'total',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
            ],
          
        ],
]); ?>
<script type="text/javascript">
    function settotal(){
        
        //
        var dkeys=$("#grid").yiiGridView("getSelectedRows");
       // $("#ext_billing-opids").val(dkeys);
        var SearchFieldsTable = $(".kv-grid-table>tbody");
        var trows = SearchFieldsTable[0].rows;
        var Total=0.00;
        var amt=0.00;
        var rqs='';
        var ids=[];
        $.each(trows, function (index, row) {
            var data_key=$(row).attr("data-key");
            for (i = 0; i < dkeys.length; i++) { 
                if(data_key==dkeys[i]){
                    amt=StringToFloat(trows[index].cells[4].innerHTML);
                    Total=Total+parseFloat(amt);
                }
            }
        }); 
     
      //  $("#op-requestids").val(dkeys);
     
        var tot=parseFloat(Total);
        var total=CurrencyFormat(tot,2);
        $('#total').html(total);
    
    }
    
</script>