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
use kartik\dialog\Dialog;
use yii\web\JsExpression;

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

<div class="analysisreferral-form">
    <div class="image-loader" style="display: hidden;"></div>
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-12">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                [
                    'class' => '\kartik\grid\SerialColumn',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;'],
                ],
                [
                    'class' => '\kartik\grid\CheckboxColumn',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;'],
                    /*'checkboxOptions' => function($model, $key, $index, $widget) {
                        return [
                            //'value' => $model['sampletype_id'],
                            //'checked' => $model['testname_method_id'] == 2
                            //'onclick' => "checkSample()",
                            'name' => 'sample_id',
                        ];
                    },*/
                    'name' => 'sample_ids',

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
                    'style'=>'overflow:auto; height:250px',
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
                   'footer'=>false,
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
            //'dropdownParent' => new yii\web\JsExpression('$("#modalAnalysis")'),
            //'dropdownParent' => new yii\web\JsExpression('$("#analysisextend-testname_id")'),
            //'style' => 'margin:0px;'
        ];

        echo $form->field($model,'testname_id')->widget(Select2::classname(),[
                'data' => $testname,
                //'data' => [],
                'theme' => Select2::THEME_KRAJEE,
                //'theme' => Select2::THEME_BOOTSTRAP,
                'options' => $options,
                'pluginOptions' => [
                    'allowClear' => true,
                    //'dropdownParent' => new yii\web\JsExpression('$("#modalAnalysis")'),
                    'showSearchBox' => false,
                    //'dropdownParent' => new yii\web\JsExpression('$("#analysisextend-testname_id")')
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
                <?php 
                    //if (Yii::$app->request->isAjax) {
                        //echo $this->renderAjax('_methodreference', [ 'methodProvider' => $methodrefDataProvider]);
                        echo $this->render('_methodreference', [ 'methodProvider' => $methodrefDataProvider]);
                    //}
                ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group" style="padding-bottom: 3px;">
        <div style="float:right;">
            <?= Html::button($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'add_analysis']) ?>
            <!-- <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'add_analysis','onclick'=>'verifyCheck()']) ?> -->
            <?= Html::button('Close', ['class' => 'btn', 'onclick'=>'closeDialog()']) ?>
            <br>
        </div>
    </div>
        <?php //=Html::submitButton('Add', ['class' => 'btn btn-success','onSubmit'=>'isSampleCheck()']) ?>
    </div>

    <!-- <input type="checkbox" onclick="checkFluency()"  id="fluency" checked /> -->

    <?php ActiveForm::end(); ?>
    <!--<div class="sweet-overlay" tabindex="-1" style="opacity: 2.89; display: block;"></div>
    <div class="sweet-alert showSweetAlert visible" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="true" data-has-done-function="true" data-animation="pop" data-timer="2500" style="display: block; margin-top: -194px;"><div class="sa-icon sa-error" style="display: none;">
      <span class="sa-x-mark">
        <span class="sa-line sa-left"></span>
        <span class="sa-line sa-right"></span>
      </span>
    </div><div class="sa-icon sa-warning pulseWarning" style="display: block;">
      <span class="sa-body pulseWarningIns"></span>
      <span class="sa-dot pulseWarningIns"></span>
    </div><div class="sa-icon sa-info" style="display: none;"></div><div class="sa-icon sa-success" style="display: none;">
      <span class="sa-line sa-tip"></span>
      <span class="sa-line sa-long"></span>

      <div class="sa-placeholder"></div>
      <div class="sa-fix"></div>
    </div><div class="sa-icon sa-custom" style="display: none;"></div><h2>Can\'t proceed: No Method selected!</h2>
    <p></p>
    <fieldset>
      <input type="text" tabindex="3" placeholder="">
      <div class="sa-input-error"></div>
    </fieldset><div class="sa-error-container">
      <div class="icon">!</div>
      <p>Not valid!</p>
    </div><div class="sa-button-container">
      <button class="cancel" tabindex="2" style="display: none;">Cancel</button>
      <div class="sa-confirm-button-container">
        <button class="confirm" tabindex="1" style="display: inline-block; background-color: rgb(140, 212, 245); box-shadow: rgba(140, 212, 245, 0.8) 0px 0px 2px, rgba(0, 0, 0, 0.05) 0px 0px 0px 1px inset;">OK</button><div class="la-ball-fall">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </div></div>-->
</div>
<?php
// Warning alert for no selected sample or method
echo Dialog::widget([
    'libName' => 'alertWarning', // a custom lib name
    'options' => [  // customized BootstrapDialog options
        'size' => Dialog::SIZE_SMALL, // large dialog text
        'type' => Dialog::TYPE_DANGER, // bootstrap contextual color
        'title' => "<i class='glyphicon glyphicon-alert' style='font-size:20px'></i> Warning",
        'buttonLabel' => 'Close',
    ]
]);

?>
<script type="text/javascript">

    //function verifyCheck(){
    $('#add_analysis').on('click',function(){
        var key_sample = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
        var radioval = $("input[name='methodref_id']").val();
        
        if(key_sample.length < 1) {
            alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No sample selected!</p>");
            return false;
        }
        else if ($('input[type=radio][name=methodref_id]', '#method-reference-grid').length < 1) {
            alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No Method selected!</p>");
            return false;
        }
        //else if ($('input[type=radio][name=kvradio]', '#method-reference-grid').length) {
        else if(!$("input[name='methodref_id']").is(":checked") || radioval == "") {
            //{
            alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No Method selected!</p>");
            //}
            //return false;
        }
        else { //if (key_sample.length > 0 && radioval > 0) {
            $('.image-loader').addClass('img-loader');
            $(".analysisreferral-form form").submit();
            $('.image-loader').addClass('img-loader');
            //$("form").submit();
            //alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>NO ERROR: SUBMIT!</p>");
            //return true;
            /*$.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'application/json',
                data: $(".analysisreferral-form form").serialize(),
                success: function(data) {
                    //... do something with the data...
                }
            });*/
            <?php 
               /*echo "$.ajax({
                    url: '".Url::toRoute("analysisreferral/create?request_id=".Yii::$app->request->get('request_id'))."',
                    type: 'post',
                    dataType: 'application/json',
                    data: $('.analysisreferral-form form').serialize(),
                    success: function (data) {
                        $('.image-loader').removeClass('img-loader');
                    },
                    beforeSend: function (xhr) {
                        //alert('Please wait...');
                        $('.image-loader').addClass('img-loader');
                    }
                });";*/
            ?>
        }

        //if(jQuery('input[type=radio][name=kvradio]', '#method-reference-grid').length<1) {
        //if($("input[name='kvradio']:checked").val() < 1){
        //if($('#method-reference-grid').on('grid.radiocleared').length < 1){
            //return true;
            //var radiocheck = $("input[name='kvradio']:checked").val();

            //if(radiocheck.length<1){
         //       alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No Method selected!</p>");
         //       return false;
            //}
       // }
        /*var radio = $grid.on('grid.radiochecked', function(ev, key, val) {
            console.log("Key = " + key + ", Val = " + val);
        });*/
        //return false;
    //}
    });

    function closeDialog(){
        $(".modal").modal('hide'); 
    };

    function checkMethodref(){
        //var $grid = $('#method-reference-grid'); // your grid identifier 
        //var getVal = "";
        //$grid.on('grid.radiochecked', function(ev, key, val) {
            //alert("Key = " + key + ", Val = " + val);
            //getVal.val(val);
        //});

        //var v;

        //var $grid = $('#method-reference-grid'); // your grid identifier 
     
        //$grid.on('grid.radiochecked', function(ev, key, val) {
            //console.log("Key = " + key + ", Val = " + val);
            //alert(val);
            //return val;
            //v = val;
            //alert(v);
        //});

        //return v.val();

        //alert(methodreferenceId);

            //return methodreferenceId;

        //alert($grid.on('grid.radiochecked').val());
        /*$grid.on('grid.radiocleared', function(ev, key, val) {
            alert("Key = " + key + ", Val = " + val);
        });*/
    }

    /*function verifyCheck()
    {
        //var method = checkMethodref(methodreferenceId);
        var samples = checkSample();
        var method = checkMethodref();

        alert(samples+ ' Method: ' + method);

    }*/

    function checkSample()
    {
        //var key_sample = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
        //var key_method = $('#method-reference-grid').yiiGridView('getSelectedRows');
        
        /*if(key_sample.length < 1) {
            alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No sample selected!</p>");
            return false;
        }*/
        //var select_all = $('.select-on-check-all').;

        //return key_sample;
        //alert(key_sample);

        /*$(".select-on-check-all").click(function(){
            var keys = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
            alert(keys);
        });*/

        /*var $grid = $('#method-reference-grid'); // your grid identifier 
     
        $grid.on('grid.radiochecked', function(ev, key, val) {
            alert("Key = " + key + ", Val = " + val);
        });*/
     

        //checkMethodref();

        /*if(key_method.length < 1)
        {
            alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No Method selected!</p>");
            return false;
        }*/
    }

</script>
<?php

$js=<<<SCRIPT
    //kv-row-checkbox
    /*$(".kv-row-checkbox").click(function(){
        var keys = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
        //$("#sample_ids").val(keylist);
        //$("#sample_ids").val(keylist);
        $("#add_analysis").prop('disabled', keys=='');  
    });
    //select-on-check-all
    $(".select-on-check-all").change(function(){
        var keys = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
        $("#add_analysis").prop('disabled', keys=='');  
   });*/
  
SCRIPT;
//$this->registerJs($js);

$this->registerJs("
    //$.fn.modal.Constructor.prototype.enforceFocus = function() {};
    //$.fn.modal.Constructor.prototype._enforceFocus = function() {};

    //kv-row-checkbox
    /*$('.kv-row-checkbox').click(function(){
        var keys = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
       //var keylist= keys.join();
        //$('#add_analysis').prop('disabled', keys=='');
    });
    //select-on-check-all
    $('.select-on-check-all').change(function(){
        var keys = $('#sample-analysis-grid').yiiGridView('getSelectedRows');
        //var keylist= keys.join();
        //$('#add_analysis').prop('disabled', keys=='');
   });*/

    $('#sample-analysis-grid').on('change',function(){
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
            //alert('No sample selected!');
            alertWarning.alert(\"<p class='text-danger' style='font-weight:bold;'>No sample selected!</p>\");
            select.val('').trigger('change');
        }
    });
");
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
/*.select-dropdown {
  position: static;
}
.select-dropdown .select-dropdown--above {
      margin-top: 336px;
}*/
</style>