<?php
use kartik\grid\GridView;
use yii\helpers\Html;
?>

<div class="view">
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'expiration_date',
            'suppliers.suppliers',
            'quantity',
            'amount',
        ],
    ]); ?>
</div>

<?php if(Yii::$app->request->isAjax){ ?>
    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
<?php } ?>