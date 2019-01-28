





<?php
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\lab\Tagging;
use common\models\system\Profile;
$js=<<<SCRIPT

$(".kv-row-checkbox").change(function(){
   var keys = $('#analysis-grid').yiiGridView('getSelectedRows');
   var keylist= keys.join();
   $("#sample_ids").val(keylist); 
  
});    
$(".select-on-check-all").change(function(){
 var keys = $('#analysis-grid').yiiGridView('getSelectedRows');
 var keylist= keys.join();
 $("#sample_ids").val(keylist);
 
 
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
                   
          });
  }

SCRIPT;
$this->registerJs($js, $this::POS_READY);

?>



</body>
</html>

<!DOCTYPE html>
<html>
<style>

#myBar {
/* set default value of progress bar */
  width: 0%;
  height: 30px;
  background-color: #2e86c1 ;
  text-align: center;
  line-height: 30px;
  color: white;
}
</style>
<body>




</body>
</html>

<div id="janeedi">
<div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>Sample Name:</b> Please scan barcode in the dropdown list below. .</p>
     
    </div>
<?php

$max = 100/$count; 
$num = $samcount * $max;

// $max = 99;
// $num = 100;

//echo $count."<br>".$samcount;


//count muna ilan ang completed para icompare dito
?>

<div class="progress" >
    <div id="myBar" class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow=<?php echo $num?> aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $num."%"?>">
      <span class="sr-only">70% Complete</span>
    </div>
    </div>

<?= Html::textInput('max', $max, ['class' => 'form-control', 'id'=>'max','type'=>'hidden'], ['readonly' => true]) ?>
<?= Html::textInput('text', $num, ['class' => 'form-control', 'id'=>'text','type'=>'hidden'], ['readonly' => true]) ?>

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
        'style'=>'overflow:auto; height:320px',
    ],
    'pjaxSettings' => [
        'options' => [
            'enablePushState' => false,
        ]
    ],
    'floatHeaderOptions' => ['scrollingTop' => true],
    'columns' => [
           ['class' => '\kartik\grid\CheckboxColumn'],
          
     [
        'header'=>'Procedure',
        'hAlign'=>'center',
        'format' => 'raw',
        'enableSorting' => false,
        'value'=> function ($model){
            return $model->procedure_name;   
        },
        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                   
    ],
        [
            'header'=>'Analyst',
            'hAlign'=>'center',
            'format' => 'raw',
            'enableSorting' => false,
            'value'=> function ($model){
                $tagging= Tagging::find()->where(['analysis_id'=> $model->procedure_id])->one();

                if ($tagging){
                    $profile= Profile::find()->where(['user_id'=> $tagging->user_id])->one();
                    return $profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
                }else{
                    return "";
                }  
            },
            'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                   
        ],
        [
            'header'=>'Cycle Time',
            'hAlign'=>'center',
            'format'=>'raw',
            'value' => function($model) {
                    return "";
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
            ],
        [
              'header'=>'Status',
              'hAlign'=>'center',
              'format'=>'raw',
              'value' => function($model) {
                    $tagging= Tagging::find()->where(['analysis_id'=> $model->procedure_id])->one();
                    if ($tagging){

                     if ($tagging->tagging_status_id==1) {
                            return "<span class='badge btn-primary' style='width:90px;height:20px'>ONGOING</span>";
                        }else if ($tagging->tagging_status_id==2) {
                            return "<span class='badge btn-success' style='width:90px;height:20px'>COMPLETED</span>";
                        }
                        else if ($tagging->tagging_status_id==3) {
                            return "<span class='badge btn-warning' style='width:90px;height:20px'>ASSIGNED</span>";
                        }
                        else if ($tagging->tagging_status_id==4) {
                            return "<span class='badge btn-danger' style='width:90px;height:20px'>CANCELLED</span>";
                        }
                         
                  
                    }else{
                        return "<span class='badge btn-default' style='width:80px;height:20px'>PENDING</span>";
                    }
                   
                  },
                  'enableSorting' => false,
                  'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
              ],
          [
            'header'=>'Remarks',
           
            'format' => 'raw',
            'width' => '100px',
            'value' => function($model) {

                $tagging= Tagging::find()->where(['analysis_id'=> $model->procedure_id])->one();
                if ($tagging){

                                            return "<b>Start Date:&nbsp;&nbsp;</b>".$tagging->start_date."
                                                <br><b>End Date:&nbsp;&nbsp;</b>".$tagging->end_date;
                                            }else{
                                                return "<b>Start Date: <br>End Date:</b>";
                                            }
                                           
                                    },
                                        'enableSorting' => false,
                                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],

],
]); 
?>

<?= Html::textInput('sample_ids', '', ['class' => 'form-control', 'id'=>'sample_ids',  'type'=>'hidden'], ['readonly' => true]) ?>
<?= Html::textInput('aid', $analysis_id, ['class' => 'form-control', 'id'=>'aid', 'type'=>'hidden'], ['readonly' => true]) ?>

<!-- <div class="alert alert-info; form-group pull-left" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>Sample Name:</b> Please scan barcode in the dropdown list below. .</p>
     
    </div> -->

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
    $.ajax({
        url: 'tagging/startanalysis',
        method: "post",
        data: { id: $('#sample_ids').val(), analysis_id: $('#aid').val()},
        beforeSend: function(xhr) {
                
                setTimeout(function() {
                    var elem = document.getElementById("myBar"); 
                    var max = $('#max').val();   
                    var text = $('#text').val();
                    var width = text;
                    var id = setInterval(frame, 0);
                    function frame() {
                        if (width >= max) {
                        clearInterval(id);
                        } else {
                            
                        width++; 
                        elem.style.width = max + '%'; 
                        elem.innerHTML = width * 1  + '%';
                        }
                    }

                }, 1000);
               


           }
        })
        .done(function( response ) {   
             $("#janeedi").html(response);
                 $('#sample_ids').val("");
        });

    }

    function completedanalysis() {

         jQuery.ajax( {
            type: 'POST',
            url: 'tagging/completedanalysis',
            data: { id: $('#sample_ids').val(), analysis_id: $('#aid').val()},
            success: function ( response ) {
               
                 $("#janeedi").html(response);
                 $('#sample_ids').val("");
               },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });

    }
</script>
