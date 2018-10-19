<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Services;
use common\models\lab\Lab;
use common\models\lab\Testname;
use common\models\lab\Methodreference;
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




$func=new Functions();



$apiUrl="https://eulimsapi.onelab.ph/api/web/v1/labs/search?labcount=0";
$curl = new curl\Curl();
$curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
$response = $curl->get($apiUrl);
$decode=Json::decode($response);

// foreach ($decode as $labsampletype) {
    
//     $labsampletypeid = $labsampletype['lab_sampletype_id'];
// }

$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');


$lablist= ArrayHelper::map($decode,'lab_id','labname');


$this->title = 'Add/ Remove Services';
$this->params['breadcrumbs'][] = $this->title;


$services =  Services::find()->all();      


?>

<?php
       
    ?>

<div class="services-index" >
   
<fieldset>
    <legend>Legend/Status</legend>
    <div>
    <span class='badge btn-success legend-font' ><span class= 'glyphicon glyphicon-check'></span> UNOFFER</span>
    <span class='badge btn-danger legend-font' ><span class= 'glyphicon glyphicon-check'></span> OFFER</span>

 
                
    </div>
</fieldset>
   
    <div class="row">
    <?php $form = ActiveForm::begin(); ?>
   
        <div>
            <?php 
          echo   $sampletype = "<div class='col-md-4'>".$form->field($model,'lab_id')->widget(Select2::classname(),[
                            'data' => $lablist,
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => ['id'=>'lab_id'],
                            'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Lab'],
                    ])."</div>"."<div class='col-md-4'>".$form->field($model, 'sampletype_id')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data'=>$sampletype,
                        'options'=>['id'=>'sample-sample_type_id'],
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['lab_id'],
                            'placeholder'=>'Select Sample Type',
                            'url'=>Url::to(['/lab/services/listsampletype']),
                            'loadingText' => 'Loading Sample Types...',
                        ]
                    ])."</div>"."<div class='col-md-4'>".$form->field($model, 'testname_method_id')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data'=>$test,
                        'options'=>['id'=>'sample-test_id'],
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['sample-sample_type_id'],
                            'placeholder'=>'Select Test',
                            'url'=>Url::to(['/lab/services/listtest']),
                            'loadingText' => 'Loading Tests...',
                        ]
                    ])."</div>";
            ?>

            
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
    
    <div class="row" id="methodreference"  style="padding-left:15px;padding-right:15px">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
               'after'=>false,
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'header'=>'Offered',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                
               
            ],
            [
                'header'=>'Method',
                'format' => 'raw',
                'enableSorting' => false,
              //  'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],
               
            ],
            [
                'header'=>'Reference',
                'format' => 'raw',
                'enableSorting' => false,
              //  'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],
               
            ],
            [
                'header'=>'Fee',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
               
            ],
            [
                'header'=>'Offered by',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
               
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div>

<script type="text/javascript">
    $('#sample-test_id').on('change',function(e) {
       e.preventDefault();
         jQuery.ajax( {
            type: 'GET',
            url: '/lab/services/getmethod?id='+$(this).val(),
            dataType: 'html',
            data: { lab_id: $('#lab_id').val(),
             sample_type_id: $('#sample-sample_type_id').val()},
            success: function ( response ) {         
              $("#methodreference").html(response);

         
            },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
    });
</script>

