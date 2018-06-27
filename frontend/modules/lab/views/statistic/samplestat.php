<?php

use yii\helpers\Html;
//use yii\grid\GridView;
//use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
//use kartik\daterange\DateRangePicker;
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
        <?php //\yii\widgets\Pjax::begin(); ?>
    	<?php
    		$form = ActiveForm::begin([
			    'id' => 'summary-sample-form',
			    'options' => [
					'class' => 'form-horizontal',
					//'data-pjax' => true,
				],
				'method' => 'get',
				//'submit'=>"return false;",/* Disable normal form submit */
				//'action'=>Yii::$app->controller->action->id,
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
				        /*echo DateRangePicker::widget([
					        'name'=>'date_range_3',
					        //'value'=>'2015-10-19 - 2015-11-03',
					        'value' => date("Y-m-d")." - ".date("Y-m-d"),
					        'convertFormat'=>true,
					        'options'=>[
					            'style' => 'width:25%;padding:5px;',
					        ],
					        'pluginOptions'=>[
					            //'timePicker'=>true,
					            //'timePickerIncrement'=>15,
					            //'locale'=>['format'=>'Y-m-d h:i A']
					            'timePicker'=>false,
					            'locale'=>['format'=>'Y-m-d'],
					        ]            
					    ]);*/
		    		?>
		    		<?php
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
		    		<button type="button" id="sample-filter" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>
		    	</div>
		    </div>
		    <?php ActiveForm::end(); ?>
		    <?php //\yii\widgets\Pjax::end(); ?>
		    <br>
		    <div class="row">
		    <?php //\yii\widgets\Pjax::begin(); ?>
        	<?php
        		//$startDate = (isset($_GET['from_date'])) ? $_GET['from_date'] : date('Y-m-01');
        		//$endDate = (isset($_GET['to_date'])) ? $_GET['to_date'] : date('Y-m-d');
        		//$labId = (isset($_GET['to_date'])) ? $_GET['to_date'] : date('Y-m-d');
        		$startDate = Yii::$app->request->get('from_date', date('Y-m-01'));
        		$endDate = Yii::$app->request->get('to_date', date('Y-m-d'));
        		$labId = (int) Yii::$app->request->get('lab_id', 1);
        		$gridColumns = [
				        //['class'=>'kartik\grid\SerialColumn'],
				        //'samplename',
				        [
				            //'attribute'=>'samplename',
				            'label' => 'Date',
				            'format' => 'raw',
				            // 'value' => function($model, $key, $index, $widget){
				            // 	//return Yii::$app->formatter->asDate($model->request->request_datetime, 'php:F j, Y');
				            // 	return $model->sample->sample_code;
				            // },
				            //'value' => 'request_datetime',
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
				            	$countSample = $model->countSample($labId,date('Y-m-d',strtotime($model->request_datetime)),$startDate,$endDate,1,$model->request_type_id);
				            	return ($countSample > 0) ? $countSample : 0;
				            	//return $startDate." ".$endDate;
				            },
				            'headerOptions' => ['class' => 'text-center'],
				            'contentOptions' => ['class' => 'text-center'],
				        ],
				        [
				            //'attribute'=>'sampling_date',
				            'label' => 'No. of Parameters',
				            'format' => 'raw',
				            'value' => function($model, $key, $index, $widget) use ($labId, $startDate,$endDate){
				            	$countAnalysis = $model->countAnalysis($labId,date('Y-m-d',strtotime($model->request_datetime)),$startDate,$endDate,2,$model->request_type_id);
				            	return ($countAnalysis > 0) ? $countAnalysis : 0;
				            },
				            'headerOptions' => ['class' => 'text-center'],
				            'contentOptions' => ['class' => 'text-center'],
				        ],
				    ];
				// $exportMenu = ExportMenu::widget([
				//     'dataProvider' => $dataProvider,
				//     'columns' => $gridColumns,
				//     'target' => ExportMenu::TARGET_SELF,
				//     'fontAwesome' => true,
				//     //'showConfirmAlert' => false,
				//     'asDropdown' => false,
				//     'dropdownOptions' => [
				//         'label' => 'Export',
				//         'class' => 'btn btn-default'
				//     ],
				//     'exportConfig' => [
				//         ExportMenu::FORMAT_TEXT => false,
				//         ExportMenu::FORMAT_HTML => false,
				//         ExportMenu::FORMAT_CSV => false,
				//         ExportMenu::FORMAT_EXCEL => [
				// 	        'label' => 'Excel 95 +',
				// 	        'icon' =>	'file-excel-o',
				// 	        'iconOptions' => ['class' => 'text-success'],
				// 	        'linkOptions' => [],
				// 	        'options' => ['title' => 'Microsoft Excel 95+ (xls)'],
				// 	        'alertMsg' => 'The EXCEL 95+ (xls) export file will be generated for download.',
				// 	        'mime' => 'application/vnd.ms-excel',
				// 	        'extension' => 'xls',
				// 	        'writer' => ExportMenu::FORMAT_EXCEL
				// 	    ],
				// 	    ExportMenu::FORMAT_EXCEL_X => [
				// 	        'label' => 'Excel 2007+',
				// 	        'icon' => 'file-excel-o',
				// 	        'iconOptions' => ['class' => 'text-success'],
				// 	        'linkOptions' => [],
				// 	        'options' => ['title' => 'Microsoft Excel 2007+ (xlsx)'],
				// 	        'alertMsg' => 'The EXCEL 2007+ (xlsx) export file will be generated for download.',
				// 	        'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				// 	        'extension' => 'xlsx',
				// 	        'writer' => ExportMenu::FORMAT_EXCEL_X
				// 	    ],
				//     ]
				// ]);
				    // echo ExportMenu::widget([
				    //     'dataProvider' => $dataProvider,
				    //     'columns' => $gridColumns,
				    //     'fontAwesome' => true,
				    // ]);
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
				    	GridView::EXCEL => [],
				        // GridView::EXCEL => [
				        //     'label' => 'Excel',
				        //     //'icon' => 'file-excel-o',
				        //     'iconOptions' => ['class' => 'text-success'],
				        //     'showHeader' => true,
				        //     'showPageSummary' => true,
				        //     'showFooter' => true,
				        //     'showCaption' => true,
				        //     'filename' => $this->title,
				        //     'alertMsg' => 'The EXCEL export file will be generated for download.',
				        //     'options' => ['title' => 'Microsoft Excel 95+'],
				        //     'mime' => 'application/vnd.ms-excel',
				        //     'config' => [
				        //         'worksheet' => $this->title,
				        //         'cssFile' => ''
				        //     ]
				        // ],
				        /*GridView::EXCEL => [
				            'label' => 'Excel',
				            //'icon' => 'file-excel-o',
				            'iconOptions' => ['class' => 'text-success'],
				            'showHeader' => true,
				            'showPageSummary' => true,
				            'showFooter' => true,
				            'showCaption' => true,
				            'filename' => $this->title,
				            'alertMsg' => 'The EXCEL export file will be generated for download.',
				            'options' => ['title' => 'Microsoft Excel 95+'],
				            'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				            'extension' => 'xlsx',
				            //'writer' => ExportMenu::FORMAT_EXCEL_X,
				            'config' => [
				                'worksheet' => $this->title,
				                'cssFile' => ''
				            ]
				        ],*/
				    ],
					'columns' => $gridColumns,
				    'toolbar' => [
	                    //'content'=> Html::button('<i class="glyphicon glyphicon-repeat"></i> Reset', ['value' => Url::to(['statistic/samples']),'class' => 'btn btn-default', 'title' => 'Reset Grid']),
	                    [
	                    'content' => Html::button('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['title'=>'Reset Grid', 'onclick'=>'reloadGrid()', 'class' => 'btn btn-default'])
	                	],
	                	'{export}',
	                    //['content' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset', ['samples'], ['class' => 'btn btn-default','title' => 'Reset Grid'])
	                    //],
	                    //'{toggleData}',
	           //          ['content'=>
				        //     Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Book', 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
				        //     Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['samples'], ['data-pjax'=>0,'class' => 'btn btn-default', 'title'=>'Reset Grid']).' '.
				        //     Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset', ['samples'], ['class' => 'btn btn-default','title' => 'Reset Grid']),
				        // ],
	                ],
	                'autoXlFormat'=>true,
	                'export'=>[
	                	'label' => 'Export',
				        'fontAwesome'=>true,
				        'showConfirmAlert'=>false,
				        'target'=>GridView::TARGET_SELF,
				     //    'dropdownOptions' => [
					    //     'label' => 'Export All',
					    //     'class' => 'btn btn-default'
					    // ]
				    ],
	       //          'export' => [
				    //     'fontAwesome' => true,
				    //     'itemsAfter'=> [
				    //         '<li role="presentation" class="divider"></li>',
				    //         '<li class="dropdown-header">Export All Data</li>',
				    //         $exportMenu
				    //     ]
				    // ],
				    //'options'=>['class'=>'text-center'],
				    //'headerOptions'=>['class'=>'text-center'],
				    //'tableOptions' =>['class' => 'table table-striped table-bordered'],
				]);
        	?>
        	<?php //\yii\widgets\Pjax::end(); ?>
        	</div>
        </div>
</div>
</div>
<script type="text/javascript">
    function reloadGrid(){
        //$('.modal-title').html($(this).attr('title'));
        //var url = $(this).attr('value');
        //$('#modal').modal('show')
          //  .find('#modalContent')
            //.load(url)
            //.modal('hide');
       //$.pjax.reload({container:"#sample-summary-pjax"});
       //$.pjax.reload({container:"#sample-summary-pjax",url: '/lab/statistic/samples',replace:false,timeout: 5000});
       //$.pjax.reload({container:"#sample-summary-pjax",url:'/lab/statistic/samples?lab_id=1&from_date=2018-06-01&to_date='.<?php echo date('Y-m-d'); ?>,replace:false,timeout: 3000});
      //alert($.now());
    	var lab_id = 1;
		var fromdate = <?= "'".date('Y-m-01')."'" ?>;
		var todate = <?= "'".date('Y-m-d')."'" ?>;
		$.pjax.reload({container:"#sample-summary-pjax",url: '/lab/statistic/samples?lab_id='+lab_id+'&from_date='+fromdate+'&to_date='+todate,replace:false,timeout: false});
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

			$.get('/lab/statistic/samples', {
		        data : $('form').serialize(),
			    }, function(response){
		    	<?php if(Yii::$app->session->hasFlash('error')): ?>
	            	echo Yii::$app->session->getFlash('error');
	            <?php else: ?>
	            	var lab_id = $('#lab_id').val();
	            	var fromdate = $('#request_date_range-start').val();
	            	var todate = $('#request_date_range-end').val();
	            	$.pjax.reload({container:"#sample-summary-pjax",url: '/lab/statistic/samples?lab_id='+lab_id+'&from_date='+fromdate+'&to_date='+todate,replace:false,timeout: false});
	            <?php 
	        		endif;
	            	Yii::$app->session->setFlash('error', null);
		        ?>
		    });
		}
	});
</script>