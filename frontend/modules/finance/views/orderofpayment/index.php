<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use common\models\lab\Customer;
use common\models\finance\Collectiontype;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\OrderofpaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\components\Functions;

$func= new Functions();
$this->params['breadcrumbs'][] = 'Order of Payments';
$this->registerJsFile("/js/finance/finance.js");
$CustomerList= ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name' );
?>
<div class="orderofpayment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Order of Payment', ['value'=>'/finance/orderofpayment/create', 'class' => 'btn btn-success create_orderofpayment','title' => Yii::t('app', "Create New Order of Payment"),'name'=>'Create Order of Payment']); ?>
    </p>
    
    <fieldset class="legend-border">
    <legend class="legend-border">Legend/Status</legend>
    <div style="padding: 0 10px">
    	<span class="icon-check"></span> <font color="#006600">Paid</font>
    </div>
    </fieldset>
    
  <div class="table-responsive">
    <?php 
    $Buttontemplate='{view}{update}{delete}'; 
    ?>
      
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'orderofpayment_id',
           // 'rstl_id',
            'transactionnum',
            [
                'attribute'=>'collectiontype_id',
                'value'=>'collectiontype.natureofcollection',
                'filter'=>Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'collectiontype_id',
                    'data' => ArrayHelper::map(Collectiontype::find()->all(), 'collectiontype_id', 'natureofcollection'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'hideSearch' => false,
                    'options' => [
                        'placeholder' => 'Select Collection Type',
                    ]
                ]),
            ],
             [
                'attribute'=>'order_date',
                
                'filter'=>DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'order_date',
                    'options' => ['placeholder' => 'Select date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]),
            ],
           [
                'attribute'=>'customer_id',
                'value'=>'customer.customer_name',
                'filter'=>Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'customer_id',
                    'data' => ArrayHelper::map(Customer::find()->all(), 'customer_id', 'customer_name'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'hideSearch' => false,
                    'options' => [
                        'placeholder' => 'Select a Customer',
                    ]
                ]),
            ],
           
            // 'amount',
            // 'purpose',
            // 'created_receipt',

            [
              //'class' => 'yii\grid\ActionColumn'
                'class' => kartik\grid\ActionColumn::className(),
                'template' => $Buttontemplate,
            ],

        ],
    ]); ?>
      
     <?php
    // This section will allow to popup a notification
    $session = Yii::$app->session;
    if ($session->isActive) {
        $session->open();
        if (isset($session['deletepopup'])) {
            $func->CrudAlert("Deleted Successfully","WARNING");
            unset($session['deletepopup']);
            $session->close();
        }
        if (isset($session['updatepopup'])) {
            $func->CrudAlert("Updated Successfully");
            unset($session['updatepopup']);
            $session->close();
        }
        if (isset($session['savepopup'])) {
            $func->CrudAlert("Saved Successfully","SUCCESS",true);
            unset($session['savepopup']);
            $session->close();
        }
    }
    ?>
  </div>
</div>
