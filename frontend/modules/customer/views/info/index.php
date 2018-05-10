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
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create New Customer', ['value'=>'/customer/info/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create New Customer"),'name'=>'Create New Customer']); ?>
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

                'customer_id',
                'rstl_id',
                'customer_code',
                'customer_name',
                'head',
                //'tel',
                //'fax',
                //'email:email',
                //'address',
                //'latitude',
                //'longitude',
                //'customer_type_id',
                //'business_nature_id',
                //'industrytype_id',
                //'created_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>