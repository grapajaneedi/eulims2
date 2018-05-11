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
$this->title = 'Order of Payment';
$this->params['breadcrumbs'][] = 'Order of Payment';
$this->registerJsFile("/js/finance/finance.js");
$CustomerList= ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name' );
?>
<div class="orderofpayment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Order of Payment', ['value'=>'/finance/orderofpayment/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create New Order of Payment"),'name'=>'Create Order of Payment']); ?>
    </p>
    
    <fieldset>
    <legend>Legend/Status</legend>
    <div style="padding: 0 10px">
    	<span class="glyphicon glyphicon-check"></span> <font color="#006600">Paid</font>
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
                'attribute' => 'collectiontype_id',
                'label' => 'Collection Type',
                'value' => function($model) {
                    return $model->collectiontype->natureofcollection;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(CollectionTYpe::find()->asArray()->all(), 'collectiontype_id', 'natureofcollection'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Collection Type', 'id' => 'grid-op-search-collectiontype_id']
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
                'attribute' => 'customer_id',
                'label' => 'Customer Name',
                'value' => function($model) {
                    return $model->customer->customer_name;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Customer::find()->asArray()->all(), 'customer_id', 'customer_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Customer Name', 'id' => 'grid-op-search-customer_id']
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
