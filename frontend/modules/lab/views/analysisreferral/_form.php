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
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
/*if(count($testname) > 0){
    $data = $testname;
} else {
    $data = ['' => 'No Sampletype'] + $testname;
}*/

/*$samplecount = $sampleDataProvider->getTotalCount();
if ($samplecount==0){
    $enableRequest = true;
}else{
    $enableRequest = false;
}*/
?>

<div class="analysis-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-12">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;'],
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;'],

                ],
                /*[
                    'attribute'=>'sample_id',
                    'enableSorting' => false,
                    //'class' => '\kartik\grid\BooleanColumn',
                    //'trueLabel' => 'Yes', 
                    //'falseLabel' => 'No',
                    'contentOptions' => [
                        'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],*/
                /*[
                    'attribute'=>'sampletype_id',
                    'enableSorting' => false,
                    'value' => function($data){
                        return !empty($data->sampletype->type) ? $data->sampletype->type : null;
                    },
                ],*/
                [
                    'attribute'=>'samplename',
                    'enableSorting' => false,
                    'contentOptions' => ['style'=>'max-width:200px;'],
                ],
                [
                    'attribute'=>'description',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($data){
                        return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".date("Y-m-d h:i A",strtotime($data->sampling_date))."</b></span>,&nbsp;".$data->description : $data->description;
                    },
                   'contentOptions' => [
                        'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
            ];

            echo GridView::widget([
                'id' => 'sample-analysis-grid',
                'dataProvider'=> $sampleDataProvider,
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
                    'style'=>'overflow:auto; height:180px',
                ],
                'floatHeaderOptions' => ['scrollingTop' => true],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'bordered' => true,
                'panel' => [
                   'heading'=>'<h3 class="panel-title">Samples</h3>',
                   'type'=>'primary',
                   'before' => '',
                    //'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['disabled'=>$enableRequest, 'value' => Url::to(['sample/create','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn'])." ".Html::button('<i class="glyphicon glyphicon-print"></i> Print Label', ['disabled'=>!$enableRequest, 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/reports/preview?url=/lab/request/printlabel','request_id'=>$model->request_id]) . "';" ,'title'=>'Print Label',  'class' => 'btn btn-success']),
                   'after'=>false,
                ],
                'columns' => $gridColumns,
                'toolbar' => false,
                // 'toolbar' => [
                //     'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i>', [Url::to(['request/view','id'=>$model->request_id])], [
                //                 'class' => 'btn btn-default', 
                //                 'title' => 'Reset Grid'
                //             ]),
                //     '{toggleData}',
                // ],
            ]);
        ?>
        </div>
        </div>
    </div>
    <div class="row">
<!--        <div class="col-sm-6">

        <? /*= $form->field($model, 'test_id')->widget(DepDrop::classname(), [
            'type'=>DepDrop::TYPE_SELECT2,
            'data'=>$sampletype,
            'options'=>['id'=>'sample-sample_type_id'],
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['sample-testcategory_id'],
                'placeholder'=>'Select Test Name',
                'url'=>Url::to(['/lab/analysis/listsampletype']),
                'loadingText' => 'Loading Test Names...',
            ]
        ])->label('Sample Type')*/
        ?>
        </div>
-->
        <div class="col-sm-8">

        <?php /*$form->field($model, 'testname_id')->widget(DepDrop::classname(), [
            'type'=>DepDrop::TYPE_SELECT2,
            'data'=>[],
            //'options'=>['id'=>'analysis-testname_id'],
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                //'depends'=>['sample-testcategory_id'],
                'placeholder'=>'Select Test Name',
                'url'=>Url::to(['/lab/analysisreferral/referraltestname']),
                'loadingText' => 'Loading Test Names...',
            ]
        ])->label('Test Name') */
        $options = [
            'language' => 'en-US',
            'width' => '100%',
            'theme' => Select2::THEME_KRAJEE,
            'placeholder' => 'Select Testname',
            'allowClear' => true,
            'dropdownParent' => new yii\web\JsExpression('$("#modalAnalysis")')
            //'style' => 'margin-top: 10px;'
        ];

        echo $form->field($model,'testname_id')->widget(Select2::classname(),[
                'data' => $testname,
                //'data' => [],
                'theme' => Select2::THEME_KRAJEE,
                //'theme' => Select2::THEME_BOOTSTRAP,
                'options' => $options,
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#modalAnalysis")')
                ],
                'pluginEvents' => [
                    "change" => "function() {
                        var test_id = this.value;
                        //alert(test_id);
                        /*$.ajax({
                            url: '".Url::toRoute("analysisreferral/getreferralmethodref?testname_id='+test_id+'")."',
                            success: function (data) {
                                select2options.data = data.data;
                                select.select2(select2options);
                                select.val(data.selected).trigger('change');
                                $('.image-loader').removeClass( \"img-loader\" );
                            },
                            beforeSend: function (xhr) {
                                //alert('Please wait...');
                                $('.image-loader').addClass( \"img-loader\" );
                            }
                        });*/
                        $.ajax({
                            //url: '".Url::toRoute("analysisreferral/getreferralmethodref?testname_id='+test_id+'")."',
                            url: '".Url::toRoute("analysisreferral/gettestnamemethod")."',
                            //dataType: 'json',
                            method: 'GET',
                            data: {testname_id: test_id},
                            success: function (data, textStatus, jqXHR) {
                                $('.image-loader').removeClass( \"img-loader\" );
                                $('#methodreference').html(data);
                            },
                            beforeSend: function (xhr) {
                                //alert('Please wait...');
                                $('.image-loader').addClass( \"img-loader\" );
                            },
                            error: function (data, jqXHR, textStatus, errorThrown) {
                                console.log('An error occured!');
                                //alert('Error in ajax request');
                                //console.log(data);
                                //alert(data.error);
                            }
                        });
                        // $.post( \"".Yii::$app->urlManager->createUrl('stock/artcheck')."\", {artsel:$(this).val()}, function( data ) {
                        //     $( \".view-art\" ).html( data );
                        //     $( \".view-art-spec\" ).empty();
                        //     });
                        //     $(\"#stock-qta\").focus();
                    }",
                ],
                /*'pluginEvents'=>[
                    "change" => 'function() { 
                        var discountid=this.value;
                        console.log(discountid);
                        $.post("/ajax/getdiscount/", {
                                discountid: discountid
                            }, function(result){
                            if(result){
                               $("#erequest-discount").val(result.rate);
                            }
                        });
                    }
                ',]*/
            ])->label('Test Name');
        ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div id="methodreference">
                <?php echo $this->render('_methodreference', [ 'methodProvider' => $methodrefDataProvider]); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group" style="padding-bottom: 3px;">
        <div style="float:right;">
            <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'add_analysis', 'disabled'=>true]) ?>
            <?= Html::button('Close', ['class' => 'btn', 'onclick'=>'closeDialog()']) ?>
            <br>
        </div>
    </div>
        <?php //=Html::submitButton('Add', ['class' => 'btn btn-success','onSubmit'=>'isSampleCheck()']) ?>
    </div>

    <!-- <input type="checkbox" onclick="checkFluency()"  id="fluency" checked /> -->

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">

function isSampleCheck()
{
    var key_id = $('#sample-analysis-grid').yiiGridView('getSelectedRows');

    if(key_id.length > 0) {
        //$("#add-analysis").prop('disabled', keys=='');
        $('#add-analysis').trigger('change');
        $("#add-analysis").change(function(){
            //Validate your form here, example:
            //var validated = true;
            //if($('#nome').val().length === 0) validated = false;
 
            //If form is validated enable form
            //if(validated) $("input[type=submit]").removeAttr("disabled");
            //$("#add-analysis").removeAttr("disabled");        
            //$("#add_analysis").prop('disabled', keys=='');
            $('#add_analysis').prop('disabled', false);
         });
        //return true;
    } else {
        $('#add-analysis').trigger('change');
        $("#add_analysis").change(function(){
            //Validate your form here, example:
            //var validated = true;
            //if($('#nome').val().length === 0) validated = false;
 
            //If form is validated enable form
            //if(validated) $("input[type=submit]").removeAttr("disabled");
            //$("#add-analysis").attr("disabled", true);
            $('#add_analysis').prop('disabled', true);
         });
        alert('Can\'t proceed: No sample selected!');
    }
    //$('#add-analysis').trigger('change');
}

/*$("#sample-analysis-grid").change(function () {
    //if ($(this).is(":checked")) {
    //    alert('you need to be fluent in English to apply for the job');
        //$("#dvPassport").show();
    //} else {
        //$("#dvPassport").hide();
    //    confirm('you need to be fluent in English to apply for the job');
    //}
    //var key_id = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
    //alert('you need to be fluent in English to apply for the job');
    //alert(key_id);
    var key_id = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
    if(key_id.length>0)
    {
        //alert('you need to be fluent in English to apply for the job');
        alert(key_id);
    } else {
        return false;
    }
});*/

$('#fluency').change(function() 
{
  if(this.checked != true)
  {
        var key_id = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
       //alert('you need to be fluent in English to apply for the job');
       alert(key_id);
  }
}); 

/*function checkFluency()
{
  var checkbox = document.getElementById('fluency');
  if (checkbox.checked != true)
  {
    alert("you need to be fluent in English to apply for the job");
  }
}*/

function closeDialog(){
    $(".modal").modal('hide'); 
};

</script>
<?php

$js=<<<SCRIPT
    $(".kv-row-checkbox").click(function(){
        var keys = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
        //$("#sample_ids").val(keylist);
        //$("#sample_ids").val(keylist);
        $("#add_analysis").prop('disabled', keys=='');  
    });    
    $(".select-on-check-all").change(function(){
        var keys = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
        $("#add_analysis").prop('disabled', keys=='');  
   });
  
SCRIPT;
$this->registerJs($js);

$this->registerJs("$('#sample-analysis-grid').on('change',function(){
    //var id = $('#saved_templates').val();
    var key_id = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
    var select = $('#analysisextend-testname_id');
    select.find('option').remove().end();
        /*$.ajax({
            //url: '".Url::toRoute("sample/getlisttemplate?template_id='+id+'")."',
            //url: '".Url::toRoute("analysisreferral/getreferraltestname")."',
            url: '".Url::toRoute("analysisreferral/getreferraltestname?sample_id='+key_id+'")."',
            //dataType: 'json',
            dataType: 'html',
            method: 'GET',
            //data: {id: $(this).val()},
            //data: {sample_id: key_id},
            success: function (data, textStatus, jqXHR) {
                //$('#sample-samplename').val(data.name);
                //$('#sample-description').val(data.description);
                //$('.image-loader').removeClass( \"img-loader\" );
                //$('#analysisextend-testname_id').html(data);
                $('#analysisextend-testname_id').select2({'value':data.test_name});
            },
            beforeSend: function (xhr) {
                //alert('Please wait...');
                //$('.image-loader').addClass( \"img-loader\" );
            },
            error: function (data, jqXHR, textStatus, errorThrown) {
                //console.log('An error occured!');
                //alert('Error in ajax request');
                console.log(data);
                alert(data.error);
            }
        });*/
        /*$('#analysisextend-testname_id').select2({
            ajax: {
                url: '".Url::toRoute("analysisreferral/getreferraltestname?sample_id='+key_id+'")."',
                processResults: function (data) {
                  // Tranforms the top-level key of the response object from 'items' to 'results'
                  return {
                    results: data.items
                  };
                }
            }
        });*/
    if(key_id.length > 0) {
        $.ajax({
            url: '".Url::toRoute("analysisreferral/getreferraltestname?sample_id='+key_id+'")."',
            success: function (data) {
                var select2options = ".Json::encode($options).";
                select2options.data = data.data;
                select.select2(select2options);
                select.val(data.selected).trigger('change');
                $('.image-loader').removeClass( \"img-loader\" );
            },
            beforeSend: function (xhr) {
                //alert('Please wait...');
                $('.image-loader').addClass( \"img-loader\" );
            }
        });
    } else {
        alert('No sample selected!');
    }
});");
?>
<style type="text/css">
/* Absolute Center Spinner */
.img-loader {
    position: fixed;
    z-index: 999;
    /*height: 2em;
    width: 2em;*/
    height: 64px;
    width: 64px;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: url('/images/img-loader64.gif');
    background-repeat: no-repeat;
}
/* Transparent Overlay */
.img-loader:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
}
</style>