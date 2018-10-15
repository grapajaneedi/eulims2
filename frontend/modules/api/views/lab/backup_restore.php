<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Services;
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
//echo $func->GetAccessToken(11);




$apiUrl="https://api3.onelab.ph/lab/get-lab?tk=8b5db6ea832b625640122db3e6367b0debca46b4&id=11&rid=11";
$curl = new curl\Curl();
$response = $curl->get($apiUrl);

//$decode=Json::decode($response);
// echo '<pre>';
// print_r($response);
// echo '</pre>';
// echo $response;

// $sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');
// $lablist= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');

$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$year = ['2013', '2014', '2015', '2016', '2017'];

//$lablist= ArrayHelper::map( $decode,'lab_id','labname');

$this->title = 'Backup and Restore';
$this->params['breadcrumbs'][] = $this->title;



?>

<?php
       
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
    <?php $form = ActiveForm::begin(); ?>
   
        <div>
            <?php 
          echo   $sampletype = "<div class='row'><div class='col-md-2'  style='margin-left:15px'>".$form->field($model,'month')->widget(Select2::classname(),[
                            'data' => $month,
                            'id'=>'month',
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => ['id'=>'month'],
                            'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Month'],
                    ])."</div>"."<div class='col-md-2'>".$form->field($model,'year')->widget(Select2::classname(),[
                        'data' => $year,
                        'id'=>'year',
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['id'=>'year'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Year'],
                ])."</div>"."<div class='col-md-4' style='margin-top:4px'><br><span class='btn btn-success' id='offer' onclick='restore()'>RESTORE</span>"."</div></div>";
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
   
    <div class = "row" style="padding-left:15px;padding-right:15px" id="methodreference">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'testname-grid',
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
               'after'=>false,
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          
            'activity',
            'date',
            'data',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
  
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
        
                        $.post('/api/lab/res', {
                           month: m,
                           year: y,
                        }, function(result){
                            // alert(m);
                            // alert(y);
                            $("#methodreference").html(response);
                            $("#testname-grid").yiiGridView("applyFilter");    
                        });
                }
</script>


