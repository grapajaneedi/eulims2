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

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Summary of Samples';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="samplestat-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
        <div class="panel-body">
    		<div class="row">
		        <div style="width:25%;position: relative; float:left;margin-right: 20px;">
		            <?php
		            	echo '<label class="control-label">Laboratory </label>';
						echo Select2::widget([
						    'name' => 'lab_id',
						    'data' => $laboratories,
						    'theme' => Select2::THEME_KRAJEE,
						    'options' => ['placeholder' => 'Select Laboratory '],
						    'pluginOptions' => [
						        'allowClear' => true,
						    ],
						]);
		            ?>
		         </div>
		         <div style="position: relative; float: left;margin-left: 20px;">
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
						    'value' => date("Y-m-d")." - ".date("Y-m-d"),
						    'useWithAddon'=>true,
						    'convertFormat'=>true,
						    'startAttribute' => 'from_date',
						    'endAttribute' => 'to_date',
						    'options'=>[
						    	'class' => 'form-control',
					            'style' => 'padding:5px;width:300px;',
					        ],
						    'pluginOptions'=>[
						        'locale'=>['format' => 'Y-m-d'],
						    ]
						]);
						echo '</div>';
		    		?>
		    	</div>
		    	 <div style="width:15%;position: relative; float:left;margin: 25px 0 0 10px;">
		    		<button type="button" class="btn btn-primary">Search</button>
		    	</div>
		    </div>
		    <br>
		    <div class="row">
        	<?php
        		echo GridView::widget([
				    'dataProvider'=> $dataProvider,
				    'summary' => false,
					//'columns' => $gridColumns,
					'columns'=>[
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
				            //'group'=>true,  // enable grouping
				        ],
				        [
				        	'label' => 'Sample',
				        	'format' => 'raw',
				        	'value' => function($model, $key, $index, $widget){
				            	//return Yii::$app->formatter->asDate($model->request->request_datetime, 'php:F j, Y');
				            	return $model->countSample('2',date('Y-m-d',strtotime($model->request_datetime)),"2018-05-01","2018-06-21",'1','1');
				            },
				        ],
				        [
				            //'attribute'=>'sampling_date',
				            'label' => 'Parameters',
				            'format' => 'raw',
				            'value' => function($model, $key, $index, $widget){
				            	//return Yii::$app->formatter->asDate($model->request->request_datetime, 'php:F j, Y');
				            	return $model->countAnalysis('1',date('Y-m-d',strtotime($model->request_datetime)),"2018-05-01","2018-06-21",'2','1');
				            },
				        ],
				    ],
				    'responsive'=>true,
				    'hover'=>true
				]);
        	?>
        </div>
        </div>
</div>
</div>