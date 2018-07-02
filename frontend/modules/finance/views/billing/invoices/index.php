<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Customer;
use common\models\finance\Client;
use common\models\finance\Collectiontype;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\Op */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\components\Functions;

$func= new Functions();
$this->title = 'Invoices';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance/']];
$this->params['breadcrumbs'][] = ['label' => 'Billing', 'url' => ['/finance/billing']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("/js/finance/finance.js");
$CustomerList= ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name' );
$rstlID=$GLOBALS['rstl_id'];
?>
<div class="billinvoice-index">
    <?php
        echo $func->GenerateStatusLegend("Legend/Status",true);
    ?>
    <p>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Bill Invoice', ['value'=>'/finance/ar/create','onclick'=>'ShowModal(this.title,this.value)', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Bill Invoice"),'id'=>'btnInvoice']); ?>
    </p>
  <div class="table-responsive">
    <?php 
    $Buttontemplate='{view}{update}'; 
    ?>      
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'responsive'=>false,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'customer_id',
                'label' => 'Customer Name',
                'value' => function($model) {
                    return $model->customer->customer_name;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map($func->GetClientList($rstlID), 'customer_id', 'customer_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Customer Name', 'id' => 'grid-op-search-customer_id']
            ],
            [
                'attribute'=>'invoice_number',
                'label'=>'Bill Invoice #',
            ],
            [
                'attribute'=>'billing_date',
                'hAlign' => 'center',
                'value'=>function($model){
                    return date('m/d/Y',strtotime($model->billing_date));
                }
            ],
            [
                'attribute'=>'due_date',
                'hAlign' => 'center',
                'value'=>function($model){
                    return date('m/d/Y',strtotime($model->due_date));
                }
            ],
            [
                'attribute'=>'amount',
                'hAlign' => 'right',
                'value'=>function($model){
                    return number_format($model->amount,2);
                }
            ],
            [
               'label'=>'Status', 
               'format'=>'raw',
               'value'=>function($model){
                    if($model->receipt_id){
                       return "<button class='btn btn-block btn-success'>Paid</button>"; 
                      // return "<button class='badge ".$Obj[0]['class']." legend-font'><span class=".$Obj[0]['icon']."></span> $Obj[0]['status']</span>";
                    }else{
                       return "<button class='btn btn-primary btn-block'>Unpaid</button>"; 
                    }
                   //
                }
               
            ],
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => $Buttontemplate,
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/finance/ar/view?id=' . $model->billing_id,'onclick'=>'ShowModal(this.title,this.value)', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Billing")]);
                    },
                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => '/finance/ar/update?id=' . $model->billing_id, 'onclick' => 'ShowModal(this.title,this.value)', 'class' => 'btn btn-success', 'title' => Yii::t('app', "Update Billing")]);
                    }
                ],
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
            $func->CrudAlert("Successfully Saved","SUCCESS",true);
            unset($session['savepopup']);
            $session->close();
        }
        if (isset($session['errorpopup'])) {
            $func->CrudAlert("Transaction Error","ERROR",true);
            unset($session['errorpopup']);
            $session->close();
        }
        if (isset($session['checkpopup'])) {
            $func->CrudAlert("Insufficient Wallet Balance","INFO",true,false,false);
            unset($session['checkpopup']);
            $session->close();
        }
    }
    ?>
  </div>
</div>
<script type="text/javascript">
    $('#btnOP').click(function(){
        $('.modal-title').html($(this).attr('title'));
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
  
</script>
