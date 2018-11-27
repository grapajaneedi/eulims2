<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

	<?php $form = ActiveForm::begin(); ?>
	<div class="view">
	     <?= GridView::widget([
	        'dataProvider' => $dataProvider,
	        'columns' => [
	            ['class' => 'yii\grid\SerialColumn'],
	            'expiration_date',
	            'suppliers.suppliers',
	            'quantity',
	            'amount',
	            [
				    'header' => 'to_order',
				    'value' => function($model){
				        return Html::textInput($model->inventory_transactions_id."_name",0,['id'=>$model->inventory_transactions_id.'_id','type'=>'number','min'=>0,'max'=>$model->quantity,'onkeypress'=>"return false;"]);
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