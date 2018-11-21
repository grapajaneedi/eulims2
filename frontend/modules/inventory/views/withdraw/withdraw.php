<?php
use yii\widgets\ListView;
use yii\helpers\Html;
$columns =2;
?>
<div class="container" >
<div class="row">
	<div class="col-md-9">
		<!-- <i>Press Enter to Find</i> -->
		<div id="srcbox">
			<div class="search-wrapper">
			    <div class="input-holder">
			    	<form>
			        <input id="searchbox" type="text" class="search-input" placeholder="Type to search then press 'Enter' to Find" name="varsearch" />
			        <!-- <button idd="btnsub" class="search-icon" onclick="searchToggle(this, event);" href><span></span></button> -->
			        <?php
			        echo Html::button("<span></span>",
	                    [
	                    	'class'=>'search-icon',
	                    	'id'=>'btnsub',
	                        'onclick'=>"searchToggle(this, event);",
	                    ]
	                ); 
			        ?>
			       
			        </form>
			    </div>
			    <span  id='btnx' class="close" onclick="searchToggle(this, event);"></span>
			</div>
		</div>
		<div class="row" style="margin-top:80px;">
			<h4><b><?= $searchkey ?></b></h4>
			<?= 
				ListView::widget([
				    'dataProvider' => $dataProvider,
				    'options' => [
				        'tag' => 'div',
				        'class' => 'list-wrapper',
				        'id' => 'list-wrapper',
				    ],
				    'itemView'=>'_view',
				    'beforeItem'   => function ($model, $key, $index, $widget) use ($columns) {
			            // if ( $index % $columns == 0 ) {
			                return "<div class='box-wrapper'>";
			            // }
			        },

			        'afterItem' => function ($model, $key, $index, $widget) use ($columns) {
			            // if ( $index != 0 && $index % ($columns - 1) == 0 ) {
			                return "</div>";
			            // }
			        }
				]);
			?>
		</div>
	</div>
	<div class="col-md-3"  style="border-left: 5px solid #565656;">
		<div id="cart">
			<h4><img src="/images/icons/cart.png" height="40px" width="40px" /><b>CART</b></h4>
			
			<div>
				<ul>
					<li>Item 1</li>
					<li>Item 2</li>
					<li>Item 3</li>
					<li>Item 4</li>
					<li><i class="fa fa-search"></i>Item 5</li>
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
<?php 
$this->registerCssFile("/css/modcss/inventorymod.css", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'css-search-bar');

$this->registerJsFile("/js/inventory/searchtoggle.js", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'js-search-bar');
$this->registerJsFile("/js/inventory/float.js", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'js-cart');
?>


<script type="text/javascript">


	$( document ).ready(function() {
	    $(btnsub).click();
	});


</script>