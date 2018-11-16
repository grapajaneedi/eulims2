<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="view">
	<div>
		<?php 
	$var = Url::base()."/".$model->Image1;
	 ?>
	 <img src="<?= $var ?>" class="img-modal" name="Withdraw" title="/inventory/inventoryentries/withdraw">
	<?php echo Html::encode($model->getAttributeLabel('product_name')); ?>:<br>
	<b><?php echo Html::a(Html::encode($model->product_name), array('view', 'id'=>$model->product_id)); ?></b>
	</div>
</div>

<script type="text/javascript">
	function myfunc(){
		alert("hi");
	}
</script>