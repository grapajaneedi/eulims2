<?php

use yii\helpers\Html;
//use yii\grid\GridView;
//use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\models\lab\Lab;
use kartik\grid\Module;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\export\ExportMenu;
use kartik\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Summary of Samples';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="samplestat-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
        <div class="panel-body">
    	<?php
    		$form = ActiveForm::begin([
			    'id' => 'summary-sample-form',
			    'options' => [
					'class' => 'form-horizontal',
					//'data-pjax' => true,
				],
				'method' => 'get',
			])
    	?>
    		<div class="row">
		        <div id="lab-name" style="width:25%;position: relative; float:left;margin-right: 20px;">
		            <?php
		            	echo '<label class="control-label">Laboratory </label>';
						echo Select2::widget([
						    'name' => 'lab_id',
						    'id' => 'lab_id',
						    'value' => (!isset($_GET['lab_id'])) ? 1 : (int) $_GET['lab_id'],
						    'data' => $laboratories,
						    'theme' => Select2::THEME_KRAJEE,
						    'options' => ['placeholder' => 'Select Laboratory '],
						    'pluginOptions' => [
						        'allowClear' => true,
						    ],
						]);
		            ?>
		            <span class="error-lab text-danger" style="position:fixed;"></span>
		         </div>
		         <div id="date_range" style="position: relative; float: left;margin-left: 20px;">
    				<?php
				        echo '<label class="control-label">Request Date </label>';
		    			echo '<div class="input-group drp-container">';
						echo DateRangePicker::widget([
						    'name'=>'request_date_range',
						    'id'=>'request_date_range',
						    'value' => (!isset($_GET['request_date_range'])) ? date("Y-m-d")." to ".date("Y-m-d") : $_GET['request_date_range'],
						    'useWithAddon'=>true,
						    'convertFormat'=>true,
						    'startAttribute' => 'from_date',
						    'endAttribute' => 'to_date',
						    'options'=>[
						    	'class' => 'form-control',
					            'style' => 'padding:5px;width:300px;',
					        ],
						    'pluginOptions'=>[
						        'locale'=>[
						        	'format' => 'Y-m-d',
						        	'separator'=>' to ',
						        ],
						    ]
						]);
						echo '</div>';
		    		?>
		    		<span class="error-date text-danger" style="position:fixed;"></span>
		    	</div>
		    	 <div style="width:15%;position: relative; float:left;margin: 27px 0 0 10px;">
		    		<button type="button" id="sample-filter" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Filter</button>
		    	</div>
		    </div>
		    <?php ActiveForm::end(); ?>
		    <br>
		    <div class="row">
		    <?php //\yii\widgets\Pjax::begin(); ?>
        	<?php
        		$startDate = Yii::$app->request->get('from_date', date('Y-m-01'));
        		$endDate = Yii::$app->request->get('to_date', date('Y-m-d'));
        		$labId = (int) Yii::$app->request->get('lab_id', 1);
        		$gridColumns = [
			        //['class'=>'kartik\grid\SerialColumn'],
			        [
			            'label' => 'Date',
			            'format' => 'raw',
			            'value' => function($model, $key, $index, $widget){
			            	//return Yii::$app->formatter->asDate($model->request->request_datetime, 'php:F j, Y');
			            	return Yii::$app->formatter->asDate($model->request_datetime, 'php:Y-m-d');
			            },
			            'headerOptions' => ['class' => 'text-center'],
			            'contentOptions' => ['class' => 'text-center'],
			        ],
			        [
			        	'label' => 'No. of Samples',
			        	'format' => 'raw',
			        	'value' => function($model, $key, $index, $widget) use ($labId, $startDate,$endDate) {
			            	$countSample = $model->countSummary($labId,date('Y-m-d',strtotime($model->request_datetime)),$startDate,$endDate,1,$model->request_type_id);
			            	return ($countSample > 0) ? $countSample : 0;
			            },
			            'headerOptions' => ['class' => 'text-center'],
			            'contentOptions' => ['class' => 'text-center'],
			        ],
			        [
			            'label' => 'No. of Parameters',
			            'format' => 'raw',
			            'value' => function($model, $key, $index, $widget) use ($labId, $startDate,$endDate){
			            	$countAnalysis = $model->countSummary($labId,date('Y-m-d',strtotime($model->request_datetime)),$startDate,$endDate,2,$model->request_type_id);
			            	return ($countAnalysis > 0) ? $countAnalysis : 0;
			            },
			            'headerOptions' => ['class' => 'text-center'],
			            'contentOptions' => ['class' => 'text-center'],
			        ],
			    ];
        		echo GridView::widget([
        			'id' => 'sample-summary',
				    'dataProvider' => $dataProvider,
				    'summary' => false,
					//'columns' => $gridColumns,
					'pjax'=>true,
	                'pjaxSettings' => [
	                    'options' => [
	                        'enablePushState' => false,
	                    ]
	                ],
	                'responsive'=>true,
	                'striped'=>true,
	                'hover'=>true,
	                'panel' => [
	                    'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Summary of Samples</h3>',
	                    'type'=>'primary',
	                    'after'=>false,
	                    //'before'=>$exportMenu,
	                    //'headerOptions' => ['class' => 'text-center'],
	                ],
	               'exportConfig' => [
				    	//GridView::CSV => [],
				    	//GridView::HTML => [],
				   		GridView::PDF => [],
				    	//GridView::EXCEL => [],
				        GridView::EXCEL => [
				            'label' => 'Excel',
				            //'icon' => 'file-excel-o',
				            //'iconOptions' => ['class' => 'text-success'],
				            'showHeader' => true,
				            'showPageSummary' => true,
				            'showFooter' => true,
				            'showCaption' => true,
				            //'filename' => 'Summary of Samples',
				            //'worksheet' => 'Summary of Samples',
				            //'alertMsg' => 'The EXCEL export file will be generated for download.',
				            'options' => ['title' => 'Microsoft Excel 95+'],
				            'mime' => 'application/vnd.ms-excel',
				            'extension' => 'xls',
				            'filename' => Lab::findOne($labId)->labcode.'-Samples_('.$startDate."_".$endDate.")",
				            'config' => [
				                //'worksheet' => $this->title,
				                'cssFile' => ''
				            ]
				        ],
				    ],
					'columns' => $gridColumns,
				    'toolbar' => [
	                    //'content'=> Html::button('<i class="glyphicon glyphicon-repeat"></i> Reset', ['value' => Url::to(['statistic/samples']),'class' => 'btn btn-default', 'title' => 'Reset Grid']),
	                    [
	                    'content' => Html::button('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['title'=>'Reset Grid', 'onclick'=>'reloadGrid()', 'class' => 'btn btn-default'])
	                	],
	                	'{export}',
	                ],
	                'autoXlFormat'=>true,
	                'export'=>[
	                	'label' => 'Export',
				        'fontAwesome'=>true,
				        'showConfirmAlert'=>false,
				        'target'=>GridView::TARGET_SELF,
				    ],
				]);
        	?>
        	<?php //\yii\widgets\Pjax::end(); ?>
        	</div>
        </div>
</div>
</div>
<script type="text/javascript">
    function reloadGrid(){
    	var lab_id = 1;
		var fromdate = <?= "'".date('Y-m-01')."'" ?>;
		var todate = <?= "'".date('Y-m-d')."'" ?>;
		$("#lab_id").val(lab_id).trigger('change');
		$('#request_date_range-start').val(fromdate).trigger('change');
		$('#request_date_range-end').val(todate).trigger('change');
		$('#request_date_range').val(fromdate+' to '+todate);
		$.pjax.reload({container:"#sample-summary-pjax",url: '/reports/lab/statistic/samples?lab_id='+lab_id+'&from_date='+fromdate+'&to_date='+todate,replace:false,timeout: false});
    }

	$('#sample-filter').on('click',function(event){
	    event.preventDefault();
	    event.stopImmediatePropagation();
	    if($('#lab_id').val() == ''){
			$('#lab-name').addClass('has-error');
			$('.error-lab').html('Please select laboratory.').fadeIn('fast').fadeOut(3000);
		} else if ($('#request_date_range').val() == ''){
			$('#date_range').addClass('has-error');
			$('.error-date').html('Please specify date range.').fadeIn('fast').fadeOut(3000);
		} else {
			$('#lab-name').removeClass('has-error');
			$('#date_range').removeClass('has-error');
			$('.error-lab').html('');
			$('.error-date').html('');

			$.get('/reports/lab/statistic/samples', {
		        data : $('form').serialize(),
			    }, function(response){
		    	<?php if(Yii::$app->session->hasFlash('error')): ?>
	            	echo Yii::$app->session->getFlash('error');
	            <?php else: ?>
	            	var lab_id = $('#lab_id').val();
	            	var fromdate = $('#request_date_range-start').val();
	            	var todate = $('#request_date_range-end').val();
	            	$.pjax.reload({container:"#sample-summary-pjax",url: '/reports/lab/statistic/samples?lab_id='+lab_id+'&from_date='+fromdate+'&to_date='+todate,replace:false,timeout: false});
	            <?php 
	        		endif;
	            	Yii::$app->session->setFlash('error', null);
		        ?>
		    });
		}
	});
</script>