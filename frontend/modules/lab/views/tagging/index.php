<?php

use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaggingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Tagging';
$this->params['breadcrumbs'][] = ['label' => 'Tagging', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = 'Sample Tagging';

$this->registerJsFile("/js/services/services.js");
$func=new Functions();

?>

<style type="text/css">
    .imgHover:hover{
        border-radius: 25px;
        box-shadow: 0 0 0 5pt #3c8dbc;
        transition: box-shadow 0.5s ease-in-out;
    }
        
    .animationload {
    background-color: transparent;
    height: 100%;
    left: 0;
    position: relative;
    top: 0;
    width: 100%;
    z-index: 10000;
    }
    .osahanloading {
    animation: 1.5s linear 0s normal none infinite running osahanloading;
    background: #3c8dbc none repeat scroll 0 0;
    border-radius: 50px;
    height: 50px;
    left: 50%;
    margin-left: -25px;
    margin-top: -25px;
    position: absolute;
    top: 50%;
    width: 50px;
    }
    .osahanloading::after {
    animation: 1.5s linear 0s normal none infinite running osahanloading_after;
    border-color: #3c8dbc transparent;
    border-radius: 80px;
    border-style: solid;
    border-width: 10px;
    content: "";
    height: 80px;
    left: -15px;
    position: absolute;
    top: -15px;
    width: 80px;
    }
    @keyframes osahanloading 
    {
        0% {
        transform: rotate(0deg);
        }
        50% {
        background: #85d6de none repeat scroll 0 0;
        transform: rotate(180deg);
        }
        100% {
        transform: rotate(360deg);
        }
    }

    .glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
    }

    @-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
    }

    .alert{
    display: none;
    }
</style>

<div class="tagging-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
        echo $func->GenerateStatusTagging("Legend/Status",true);
    ?>

<div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>Note:</b> Please scan barcode in the dropdown list below. .</p>
     
    </div>
    <div class="row">
             <div class="col-md-4">
                <?php $form = ActiveForm::begin(); ?>
                <?php
                        $disabled=false;
                       
                        echo $func->GetSampleCode($form,$model,$disabled,"");
                ?>    
                <?php ActiveForm::end(); ?>
                </div>
                    </div>

 <div class="row-fluid" id ="xyz">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  Sample' ,
            ],
        'columns' => [
            [
                'header'=>'Sample Name',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
               
            ],
            [
                'header'=>'Description',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
               
            ],
            
        ],
    ]); ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  Analysis',
            ],
        'columns' => [
            [
                'header'=>'Test Name',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
               
            ],
            [
                'header'=>'Method',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
               
            ],
            [
                'header'=>'Analyst',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
               
            ],
            [
                'header'=>'Status',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
               
            ],
            [
                'header'=>'Remarks',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
               
        
        ],
        
        ],
    ]); ?>
    </div>
</div>

<div id="divSpinner" style="text-align:center;display:none;font-size:30px">
     <div class="animationload">
            <div class="osahanloading"></div>
     </div>
</div>

<script type='text/javascript'>
ShowProgressSpinner(true);

</script>

<script type="text/javascript">
    $('#sample-sample_code').on('change',function(e) {
       e.preventDefault();
         jQuery.ajax( {
            type: 'GET',
            url: '/lab/tagging/getanalysis?id='+$(this).val(),
            dataType: 'html',
            success: function ( response ) {
             // $("#divSpinner").toggle();
             ShowProgressSpinner(true);
             
              $("#xyz").html(response);
            //  $("#divSpinner").hide();
             

            },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
    });
    </script>