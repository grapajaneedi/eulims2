<?php
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

$js=<<<SCRIPT

$(".kv-row-checkbox").change(function(){
   var keys = $('#analysis-grid').yiiGridView('getSelectedRows');
   var keylist= keys.join();
   $("#sample_ids").val(keylist); 
   alert("boom");
});    
$(".select-on-check-all").change(function(){
 var keys = $('#analysis-grid').yiiGridView('getSelectedRows');
 var keylist= keys.join();
 $("#sample_ids").val(keylist);
 alert("boom");
 
});

function tag(mid){
      $.ajax({
         url: '/lab/tagging/tag',
         method: "post",
          data: { id: mid},
          beforeSend: function(xhr) {
             $('.image-loader').addClass("img-loader");
             }
          })
          .done(function(response) {   
              alert("boom");            
          });
  }

SCRIPT;
$this->registerJs($js, $this::POS_READY);

?>
<div id="hi">
<div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>Note:</b> Please scan barcode in the dropdown list below. .</p>
     
    </div>
    
<?= GridView::widget([
    'dataProvider' => $analysisdataprovider,
    'pjax'=>true,
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'bordered' => true,
    'id'=>'analysis-grid',
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
     //   ['class' => 'yii\grid\SerialColumn'],
           ['class' => '\kartik\grid\CheckboxColumn'],
          
     [
        'header'=>'Procedure',
        'format' => 'raw',
        'enableSorting' => false,
        'value'=> function ($model){
            return $model->procedure_name;   
        },
        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                   
    ],
        [
            'header'=>'Analyst',
            'format' => 'raw',
            'enableSorting' => false,
            'value'=> function ($model){
                return "";   
            },
            'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                   
        ],
        [
              'header'=>'Status',
              'hAlign'=>'center',
              'format'=>'raw',
              'value' => function($model) {     
                return "";
              },
              'enableSorting' => false,
              'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
          ],
          [
            'header'=>'Remarks',
            'format' => 'raw',
            'width' => '100px',
            'value' => function($model) {
                return "";
        },
            'enableSorting' => false,
            'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
    ],

],
]); 
?>
<?= Html::textInput('sample_ids', '', ['class' => 'form-control', 'id'=>'sample_ids'], ['readonly' => true]) ?>
<div class="form-group pull-right">
<?php
echo Html::button('<i class="glyphicon glyphicon-ok"></i> Start', ['disabled'=>false,'value' => Url::to(['tagging/startanalysis','id'=>1]), 'onclick'=>'startanalysis()','title'=>'Click to start this procedure', 'class' => 'btn btn-success','id' => 'btn_start_analysis']);
?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo Html::button('<i class="glyphicon glyphicon-ok"></i> End', ['disabled'=>false,'value' => Url::to(['tagging/completedanalysis','id'=>1]),'title'=>'Click to end this procedure', 'onclick'=>'completedanalysis()', 'class' => 'btn btn-success','id' => 'btn_complete_analysis']);

?>
</div>
</div>
<script type="text/javascript">
   function startanalysis() {

         jQuery.ajax( {
            type: 'GET',
            url: 'tagging/startanalysis',
            data: { id: $('#sample_ids').val(), analysis_id: $('#aid').val()},
            success: function ( response ) {
                
              //  $("#analysis-grid").yiiGridView("applyFilter");
              //location.reload();
              $("#analysis-grid").show();
               // $("#analysis-grid").yiiGridView();
                $('#sample_ids').val("");
               //  $("#xyz").html(response);
               },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
    }

    function completedanalysis() {

         jQuery.ajax( {
            type: 'POST',
            url: 'tagging/completedanalysis',
            data: { id: $('#sample_ids').val(), analysis_id: $('#aid').val()},
            success: function ( response ) {
               
                // $("#xyz").html(response);
                // $("#analysis-grid").yiiGridView("applyFilter");
               $('#sample_ids').val("");
               },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });

    }
</script>

