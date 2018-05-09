<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("/js/customer/customer.js");

?>
<div class="customer-index">

    <p>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create New Customer', ['value'=>'/customer/info/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create New Customer"),'name'=>'Create New Wallet']); ?>
    </p>

<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'customer_id',
            'customer_code',
            'customer_name',
            'rstl_id',
            'head',
            'municipalitycity_id',
            // 'barangay_id',
            // 'district',
            // 'address',
            // 'tel',
            // 'fax',
            // 'email:email',
            // 'customer_type_id',
            // 'business_nature_id',
            // 'industrytype_id',
            // 'created_at',

            // ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 8.7%'],
                'visible'=> Yii::$app->user->isGuest ? false : true,
                'template' => '{add}{view}{update}',
                'buttons'=>[
                    // 'add'=>function ($url, $model) {
                    //     $t = '/finance/customertransaction/create?customerwallet_id='.$model->customerwallet_id;
                    //     return Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-success custom_button','title' => Yii::t('app', "Add Funds for ".$model->customer->customer_name),'name' => Yii::t('app', "Add Funds for <font color='Blue'>[<b>".$model->customer->customer_name."</b>]</font>")]);
                    // },
                    'view'=>function ($url, $model) {
                        $t = '/customer/ionfo/view?id='.$model->customer_id;
                        return Html::button('<span class="fa fa-eye"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-primary btn-modal','title' => Yii::t('app', "View Details for ".$model->customer_name),'name' => Yii::t('app', "View Details for  <font color='Blue'>[<b>".$model->customer_name."</b>]</font>")]);
                    },
                    'update'=>function ($url, $model) {
                        $t = '/customer/info/update?id='.$model->customer_id;
                        return Html::button('<span class="fa fa-pencil"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Update Details for ".$model->customer_name),'name' => Yii::t('app', "Update Details for  <font color='Blue'>[<b>".$model->customer_name."</b>]</font>")]);
                    },
                    
                ],
            ],
        ],
    ]); ?>
</div>
</div>