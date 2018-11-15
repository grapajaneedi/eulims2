<?php
use yii\helpers\Html;
?>
<div class="container">
<div class="row">
	<div class="col-md-9">
		<i>Press Enter to Find</i>
		<div class="search-wrapper">
		    <div class="input-holder">
		        <input id="searchbox" type="text" class="search-input" placeholder="Type to search" />
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
		        <?= Html::a('HAHAHA', ['withdraw'], ['class'=>'btn btn-primary']) ?>
		    </div>
		    <span class="close" onclick="searchToggle(this, event);"></span>
		</div>
		<hr>
		<div class="container">
			
		</div>
	</div>
	<div class="col-md-3"  style="border-left: 5px solid #565656;">
		<div>
			<h4><img src="/images/icons/cart.png" height="50mm" width="50mm" /><b>CART</b></h4>
		</div>
		<hr>
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
<?php 
$this->registerCssFile("/css/modcss/inventorymod.css", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'css-search-bar');

$this->registerJsFile("/js/inventory/searchtoggle.js", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'js-search-bar');
?>

<script type="text/javascript">
	// Get the input field
	var input = document.getElementById("searchbox");

	// Execute a function when the user releases a key on the keyboard
	input.addEventListener("keyup", function(event) {
	  // Cancel the default action, if needed
	  event.preventDefault();
	  // Number 13 is the "Enter" key on the keyboard
	  if (event.keyCode === 13) {
	    alert(input.value);
	  }
	});

	$( document ).ready(function() {
	    $(btnsub).click();
	});
</script>