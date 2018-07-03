<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\finance\BillingReceipt */

$this->title = 'Create Billing Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Billing Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-receipt-create">
    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
