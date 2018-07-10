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
<div class="tagging-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
        echo $func->GenerateStatusTagging("Legend/Status",true);
    ?>

    <p>
        <?php
        // Html::a('Create Tagging', ['create'], ['class' => 'btn btn-success'])
         ?>
    </p>
    <div class="row">
             <div class="col-md-4">
                <?php $form = ActiveForm::begin(); ?>
                <?php
                        $disabled=false;
                       
                        echo $func->GetSampleCode($form,$model,$disabled,"Scan or Search Sample Code");
                ?>    
                <?php ActiveForm::end(); ?>
                </div>
                    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tagging_id',
            'user_id',
            'analysis_id',
            'start_date',
            'end_date',
            //'tagging_status_id',
            //'cancel_date',
            //'reason',
            //'cancelled_by',
            //'disposed_date',
            //'iso_accredited',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<script type="text/javascript">
    $('#sample-sample_code').on('change',function(e) {
       $(this).select2('close');
       e.preventDefault();
        $('#prog').show();
        $('#requests').hide();
         jQuery.ajax( {
            type: 'POST',
            url: '/finance/op/check-customer-wallet?customerid='+$(this).val(),
            dataType: 'html',
            success: function ( response ) {
               $('#wallet').val(response);
            },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
        jQuery.ajax( {
            type: 'POST',
            //data: {
            //    customer_id:customer_id,
           // },
            url: '/finance/op/getlistrequest?id='+$(this).val(),
            dataType: 'html',
            success: function ( response ) {

               setTimeout(function(){
               $('#prog').hide();
                 $('#requests').show();
               $('#requests').html(response);
                   }, 0);


            },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
        
       //alert(paymentmode);
        $(this).select2('open');
      //  $(this).one('select-focus',select2Focus);
      $(this).attr('tabIndex',1);
       checkpayment_mode();
    });
    </script>