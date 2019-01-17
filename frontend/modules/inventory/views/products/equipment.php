<?php
use yii\widgets\ListView;
use yii\helpers\Html;
$columns =2;
?>
<div class="products-view">
<div class="container" >
<div class="row">
	<div class="col-md-10" >
		<!-- <i>Press Enter to Find</i> -->
		<div id="srcbox">
			<div class="search-wrapper">
			    <div class="input-holder">
			    	<form>
			        <input id="searchbox" type="text" class="search-input" placeholder="Type to search then press 'Enter' to Find" name="varsearch" />
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
			    <div  id='btnx' class="close" onclick="searchToggle(this, event);"></div>
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
</div>
</div>	
</div>

<?php 
$this->registerCssFile("/css/modcss/equipmentmod.css", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'css-search-bar');

$this->registerJsFile("/js/inventory/searchtoggle.js", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'js-search-bar');
$this->registerJsFile("/js/inventory/floatequipment.js", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'js-cart');
?>


<script type="text/javascript">
	$( document ).ready(function() {
	    $(btnsub).click();
	});
</script>


