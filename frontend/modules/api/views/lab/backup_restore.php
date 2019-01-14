


<?php
use yii\helpers\Html;
use yii\bootstrap\Progress;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Services;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Backuprestore;
use common\models\lab\Lab;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use common\components\Functions;
use linslin\yii2\curl;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\ServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$func=new Functions();



$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$year = ['2013', '2014', '2015', '2016', '2017', '2018', '2019'];

//$lablist= ArrayHelper::map( $decode,'lab_id','labname');

$this->title = 'Backup and Restore';
$this->params['breadcrumbs'][] = ['label' => 'API', 'url' => ['/api']];
$this->params['breadcrumbs'][] = $this->title;

    
        // $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restoresyncnew?rstl_id=11&id=10148";
        // $curl = curl_init();                   
        // curl_setopt($curl, CURLOPT_URL, $apiUrl);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
        // curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($curl);
                        
        // $data = json_decode($response, true);

        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
      

?>

<!-- <div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>EULIMS Migration</b></p>
    <br>
    <p class="note" style="color:#265e8d"><b>BY YEAR:</b> Choose a year</p>
    <p class="note" style="color:#265e8d"><b>BY MONTH:</b> Choose a month and year</p>
    <p class="note" style="color:#265e8d"><b>SYNC:</b> You can only use this if you have already migrated all the data by year</p>
    </div>
<div class="services-index"> -->
   
<fieldset>
    <legend>Legend/Status</legend>
    <div>
    <span class='badge btn-success legend-font' ><span class= 'glyphicon glyphicon-check'></span> DONE</span>
    <span class='badge btn-danger legend-font' ><span class= 'glyphicon glyphicon-check'></span> PENDING</span>

 
                
    </div>
</fieldset>
   
    <div class="row">
    <div class="image-loader" style="display: hidden;"></div>
    <?php $form = ActiveForm::begin(); ?>
   
        <div>
            <?php 
          echo   $sampletype = "<div class='row'><div class='col-md-2'  style='margin-left:15px'>".$form->field($model,'month')->widget(Select2::classname(),[
                            'data' => $month,
                            'id'=>'month',
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => ['id'=>'month'],
                            'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Month'],
                    ])->label("Month")."</div>"."<div class='col-md-2'>".$form->field($model,'year')->widget(Select2::classname(),[
                        'data' => $year,
                        'id'=>'year',
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['id'=>'year'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Year'],
                ])->label("Year")
                ."</div>"."<div class='col-md-4' style='margin-top:4px'><br><span class='btn btn-success' id='offer' onclick='restore()'>BY YEAR</span>&nbsp;&nbsp;&nbsp;<span class='btn btn-success' id='offer' onclick='restorebyyear()'>BY MONTH</span>&nbsp;&nbsp;&nbsp;<span class='btn btn-success' id='sync' onclick='restore_sync  ()'>SYNC</span>";
                //."</div><div class='col-md-4' style='margin-top:4px'><br><span class='btn btn-success' id='offer' onclick='restorebyyear()'>RESTORE BY MONTH</span><div class='col-md-4' style='margin-top:4px'><span class='btn btn-success' id='offer' onclick='restore()'>RESTORE</span></div><div class='col-md-4' style='margin-top:4px'><span class='btn btn-success' id='offer' onclick='restore()'>SYNC</span></div>";
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
  
    <div class = "row" style="padding-left:15px;padding-right:15px" id="methodreference">
    <?php

    $request = Request::find()->count();
    $analysis = Analysis::find()->count();
    $sample = Sample::find()->count();

    $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
    $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/countrequest?rstl_id=".$GLOBALS['rstl_id'];        
    $curl = curl_init();			
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);			
    $data = json_decode($response, true);

    //analysis
    $apiUrl_analysis="https://eulimsapi.onelab.ph/api/web/v1/analysisdatas/countanalysis?rstl_id=".$GLOBALS['rstl_id'];        
    $curl_analysis = curl_init();			
    curl_setopt($curl_analysis, CURLOPT_URL, $apiUrl_analysis);
    curl_setopt($curl_analysis, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl_analysis, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($curl_analysis, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
    curl_setopt($curl_analysis, CURLOPT_RETURNTRANSFER, true);
    $response_analysis = curl_exec($curl_analysis);			
    $data_analysis = json_decode($response_analysis, true);

    //sample
    $apiUrl_sample="https://eulimsapi.onelab.ph/api/web/v1/samples/countsample?rstl_id=".$GLOBALS['rstl_id'];        
    $curl_sample = curl_init();			
    curl_setopt($curl_sample, CURLOPT_URL, $apiUrl_sample);
    curl_setopt($curl_sample, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl_sample, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($curl_sample, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
    curl_setopt($curl_sample, CURLOPT_RETURNTRANSFER, true);
    $response_sample = curl_exec($curl_sample);			
    $data_sample = json_decode($response_sample, true);

   // var_dump($data_sample);
    ?>
    <?= 
    GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'testname-grid',
        'pjax' => true,
    
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> "<b>No. of Requests: </b>".number_format($request)."/ ".number_format($data)."<b><br>No. of Analyses:</b>".number_format($analysis)."/".number_format($data_analysis)."<b><br>No. of Sample: </b>".number_format($sample)."/".number_format($data_sample),
               'after'=>false,
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],     
            'activity',
            'date',
            'data',
            'month',
            'year',
            [
                'header'=>'Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                          return "<span class='badge btn-success' style='width:90px;height:20px'>COMPLETED</span>";            
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
                // 'pageSummary' => 'Total',
                // 'pageSummary' => true,               
            ],
        ],
    ]);
    ?>
</div>

<script type="text/javascript">
    $('#sample-test_id').on('change',function(e) {
       e.preventDefault();
         jQuery.ajax( {
            type: 'GET',
            url: '/lab/services/getmethod?id='+$(this).val(),
            dataType: 'html',
            data: { lab_id: $('#lab_id').val(), sample_type_id: $('#sample-sample_type_id').val()},
            success: function ( response ) {         
              $("#methodreference").html(response);
            },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
    });

    function restore(){

        var m = $('#month option:selected').text();
        var y = $('#year option:selected').text();
        
        $.ajax({
            url: "/api/lab/res",
            method: "POST",
            dataType: 'json',
            data: {month:m, year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( data ) {
                alert(data.message);
                $("#testname-grid").yiiGridView("applyFilter"); 

                $('.image-loader').removeClass("img-loader");
            });
        }

        function restorebyyear(){

        var m = $('#month option:selected').text();
        var y = $('#year option:selected').text();
        
        $.ajax({
            url: "/api/lab/resyear",
            method: "POST",
            dataType: 'json',
            data: {month:m, year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( data ) {
                alert(data.message);
                $("#testname-grid").yiiGridView("applyFilter"); 

                $('.image-loader').removeClass("img-loader");
            });
        }

        function restore_sync(){

        var m = $('#month option:selected').text();
        var y = $('#year option:selected').text();
        
        $.ajax({
            url: "/api/lab/ressync",
            method: "POST",
            dataType: 'json',
            data: {month:m, year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( data ) {
                alert(data.message);
                $("#testname-grid").yiiGridView("applyFilter"); 

                $('.image-loader').removeClass("img-loader");
            });
        }
</script>


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