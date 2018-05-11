<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Customer */

$this->title = $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'customer_id',
            'rstl_id',
            'customer_code',
            'customer_name',
            'head',
            'municipalitycity_id',
            'barangay_id',
            'district',
            'address',
            'tel',
            'fax',
            'email:email',
            'customer_type_id',
            'business_nature_id',
            'industrytype_id',
            'created_at',
        ],
    ]) ?>

</div>
