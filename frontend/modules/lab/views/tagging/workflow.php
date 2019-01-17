
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

$js=<<<SCRIPT

$(".kv-row-checkbox").click(function(){
   var keys = $('#analysis-grid').yiiGridView('getSelectedRows');
   var keylist= keys.join();
   //$("#analysis_ids").val(keylist);
   alert(keylist);
   
});    
$(".select-on-check-all").change(function(){
 var keys = $('#workflow-grid').yiiGridView('getSelectedRows');
 var keylist= keys.join();
 //$("#sample_ids").val(keylist);
 alert(keylist);
});

SCRIPT;
$this->registerJs($js);

?>
<?php
 echo GridView::widget([
        'dataProvider' => $model,
        'id'=>'analysis-grid',
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-analysis']],
        // 'panel' => [
        //         'type' => GridView::TYPE_PRIMARY,
        //         'heading' => '<span class="glyphicon glyphicon-book"></span>  Analysis' ,
        //         'footer'=>Html::button('<i class="glyphicon glyphicon-tag"></i> Start Analysis', ['disabled'=>false,'value' => Url::to(['tagging/startanalysis','id'=>1]), 'onclick'=>'startanalysis()','title'=>'Start Analysis', 'class' => 'btn btn-success','id' => 'btn_start_analysis'])." ".
        //         Html::button('<i class="glyphicon glyphicon-ok"></i> Completed', ['disabled'=>false,'value' => Url::to(['tagging/completedanalysis','id'=>1]),'title'=>'Completed', 'onclick'=>'completedanalysis()', 'class' => 'btn btn-success','id' => 'btn_complete_analysis']),
        //     ],
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ]
            ],
            'floatHeaderOptions' => ['scrollingTop' => true],
            'columns' => [
                  [
               'class' => 'yii\grid\SerialColumn',
               'class' => '\kartik\grid\CheckboxColumn',
              
               'width' => '5px',
            ],
                    [
                        'attribute'=>'procedure_name',
                        'enableSorting' => false,
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width:20%; white-space: normal;'],
                    ],
                    [
                        'header'=>'Analyst',
                        'hAlign'=>'center',
                        'format'=>'raw',
                        'value' => function($model) {
                      
                        
                         
                        },
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:30px; white-space: normal;'],
                    ],
                    [
                        'header'=>'Status',
                        'hAlign'=>'center',
                        'format'=>'raw',
                        'value' => function($model) {
                      
                        
                         
                        },
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:30px; white-space: normal;'],
                    ],
                    [
                        'header'=>'Remarks',
                        'hAlign'=>'center',
                        'format'=>'raw',
                        'value' => function($model) {
                      
                        
                         
                        },
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:30px; white-space: normal;'],
                    ],
        ],
    ]); 
    ?>

<div class='col-md-4' style='margin-top:4px'><br><span class='btn btn-success' id='offer' onclick='alert("boom")'>STARTED</span>
<span class='btn btn-success' id='offer' onclick='alert("boom")'>COMPLETED</span>
<?= Html::textInput('sample_ids', '', ['class' => 'form-control', 'id'=>'sample_ids'], ['readonly' => true]) ?>
SUMMARY HERE

<!-- <script type="text/javascript">
   function startanalysis() {

         jQuery.ajax( {
            type: 'POST',
            url: 'tagging/startanalysis',
            data: { id: $('#sample_ids').val(), analysis_id: $('#aid').val()},
            success: function ( response ) {

                 $("#xyz").html(response);
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

                 $("#xyz").html(response);
               },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });

    }
</script> -->