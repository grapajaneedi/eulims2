<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\finance\DepositType;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\Deposit */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\components\Functions;

$func= new Functions();
$this->title = 'Deposit';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Cashier', 'url' => ['/finance/cashier']];
$this->params['breadcrumbs'][] = 'Deposit';
?>
<div class="deposit-index">
     <div class="table-responsive">
    
    <?php 
    $Buttontemplate='{view}'; 
    ?>
      
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
       'responsive'=>true,
        'striped'=>true,
        'showPageSummary' => true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'panel' => [
                'type'=>'primary', 'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Create Deposit', ['value' => Url::to(['add-deposit']),'title'=>'Create Deposit', 'onclick'=>'addDeposit(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                
            ],
        'columns' => [
            [
               'attribute'=>'deposit_date',
               'filterType'=> GridView::FILTER_DATE_RANGE,
               'value' => function($model) {
                    return date_format(date_create($model->deposit_date),"m/d/Y");
                },
                'filterWidgetOptions' => ([
                     'model'=>$model,
                     'useWithAddon'=>true,
                     'attribute'=>'order_date',
                     'startAttribute'=>'createDateStart',
                     'endAttribute'=>'createDateEnd',
                     'presetDropdown'=>TRUE,
                     'convertFormat'=>TRUE,
                     'pluginOptions'=>[
                         'allowClear' => true,
                        'locale'=>[
                            'format'=>'Y-m-d',
                            'separator'=>' to ',
                        ],
                         'opens'=>'left',
                      ],
                     'pluginEvents'=>[
                        "cancel.daterangepicker" => "function(ev, picker) {
                        picker.element[0].children[1].textContent = '';
                        $(picker.element[0].nextElementSibling).val('').trigger('change');
                        }",
                        
                        'apply.daterangepicker' => 'function(ev, picker) { 
                        var val = picker.startDate.format(picker.locale.format) + picker.locale.separator +
                        picker.endDate.format(picker.locale.format);

                        picker.element[0].children[1].textContent = val;
                        $(picker.element[0].nextElementSibling).val(val);
                        }',
                      ] 
                     
                ]),        
               
            ],
            'start_or',
            [
                'attribute' => 'end_or', 
                'pageSummary' => '<span style="float:right;">Total:</span>',
            ],
                        
            [
                 'attribute' => 'amount',
                 'format' => ['decimal', 2],
                 'pageSummary' => true
            ],      
            [
                'attribute' => 'deposit_type_id',
                'label' => 'Deposit Type',
                'value' => function($model) {
                    return $model->depositType->deposit_type;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(DepositType::find()->asArray()->all(), 'deposit_type_id', 'deposit_type'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Deposit Type', 'id' => 'grid-deposit-search-deposit_type_id']
            ],
        ],
    ]); ?>
     
  </div>
</div>
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
<script type="text/javascript">
 function addDeposit(url,title){
     $(".modal-title").html(title);
     $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
</script>