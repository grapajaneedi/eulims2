


<?php
use yii\helpers\Html;
use yii\bootstrap\Progress;
use kartik\grid\GridView;
use common\models\finance\Op;
use common\models\finance\Paymentitem;
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
$year = ['2013', '2014', '2015', '2016', '2017', '2018'];

//$lablist= ArrayHelper::map( $decode,'lab_id','labname');

$this->title = 'Backup and Restore';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="services-index">
   
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
          echo   $sampletype = "<div class='row'><div class='col-md-2'  style='margin-left:15px'>".$form->field($model,'transaction_date')->widget(Select2::classname(),[
                            'data' => $month,
                            'id'=>'month',
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => ['id'=>'month'],
                            'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Month'],
                    ])->label("Month")."</div>"."<div class='col-md-2'>".$form->field($model,'op_data')->widget(Select2::classname(),[
                        'data' => $year,
                        'id'=>'year',
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['id'=>'year'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Year'],
                ])->label("Year")."</div>"."<div class='col-md-4' style='margin-top:4px'><br><span class='btn btn-success' id='offer' onclick='restore()'>RESTORE</span>&nbsp;&nbsp;&nbsp;<span class='btn btn-success' id='restore_receipt' onclick='restore_receipt()'>RESTORE Receipt</span>";
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
  
    <div class = "row" style="padding-left:15px;padding-right:15px" id="finance">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'finance-grid',
        'pjax' => true,
      //  'showPageSummary' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
               'after'=>false,
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],     
            'activity',
            'transaction_date',
            'op_data',
            'pi_data',
            'sc_data',
            'receipt_data',
            'check_data',
            'deposit_data',
            [
                'header'=>'Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                          return "<span class='badge btn-success' style='width:90px;height:20px'>COMPLETED</span>";            
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
                
            ],
        ],
    ]);
    

    ?>
  
</div>

<script type="text/javascript">
    function restore(){

        var m = $('#month option:selected').val();
        var y = $('#year option:selected').text();
    
        $.ajax({
            url: "/api/finance/res",
            method: "POST",
            data: {month:m, year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function(data) {
                $("#finance-grid").yiiGridView("applyFilter"); 
                $('.image-loader').removeClass("img-loader");
            });
        }
        function restore_receipt(){

        var y = $('#year option:selected').text();
    alert(y);
        $.ajax({
            url: "/api/finance/res_receipt",
            method: "POST",
            data: {year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function(data) {
                $("#finance-grid").yiiGridView("applyFilter"); 
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