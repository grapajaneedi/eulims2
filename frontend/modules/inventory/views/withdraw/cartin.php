<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\inventory\InventoryWithdrawaldetails;
?>

	<?php $form = ActiveForm::begin(); ?>
	<div class="view">
	     <?= GridView::widget([
	        'dataProvider' => $dataProvider,
	        'columns' => [
	            ['class' => 'yii\grid\SerialColumn'],
	            'expiration_date',
	            'suppliers.suppliers',
	            // 'quantity',
	            'amount',
	             [
				    'header' => 'Onhand',
				    'value' => function($model){
				    	$withdrawn = InventoryWithdrawaldetails::find()->where(['inventory_transactions_id'=>$model->inventory_transactions_id])->sum('quantity');

				        return $model->quantity-$withdrawn;
				    },
				    'format' => 'raw'
				],
	            [
				    'header' => 'Order',
				    'value' => function($model){
				    	$withdrawn = InventoryWithdrawaldetails::find()->where(['inventory_transactions_id'=>$model->inventory_transactions_id])->sum('quantity');

				        return Html::textInput($model->inventory_transactions_id."_name",0,['id'=>$model->inventory_transactions_id.'_id','type'=>'number','min'=>0,'max'=>$model->quantity-$withdrawn,'onkeypress'=>"return false;"]);
				    },
				    'format' => 'raw'
				],
	        ],
	    ]); ?>
	</div>

	<?php if(Yii::$app->request->isAjax){ ?>
	    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
	<?php } ?>
	 <?= Html::submitButton('Add to Cart', ['class' => 'btn btn-success pull-right']) ?>
<?php ActiveForm::end(); ?>