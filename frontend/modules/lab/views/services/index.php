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

$apiUrl="https://api3.onelab.ph/lab/get-lab?id=11";
$curl = new curl\Curl();
$response = $curl->get($apiUrl);




$decode=Json::decode($response);
echo '<pre>';
print_r($decode);
echo '</pre>';


//echo $response;


$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');
$lablist= ArrayHelper::map( $decode,'lab_id','labname');

echo '<pre>';
print_r($lablist);
echo '</pre>';




$this->title = 'Add/ Remove Services';
$this->params['breadcrumbs'][] = $this->title;


?>


<div class="services-index">
   
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
                            'url'=>Url::to(['/lab/analysis/listsampletype']),
                            'loadingText' => 'Loading Tests...',
                        ]
                    ])."</div>";
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
    
    <div class="row" id="methodreference">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
       // 'toolbar'=>[],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            //    'before'=>$sampletype,
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
            data: { lab_id: $('#lab_id').val(), sample_type_id: $('#sample-sample_type_id').val()},
            success: function ( response ) {         
              $("#methodreference").html(response);

         
            },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
    });
</script>

