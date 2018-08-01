<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\models\lab\Analysis;
use common\models\lab\SampleregisterUser;
use kartik\grid\DataColumn;
use kartik\daterange\DateRangePicker;
use kartik\grid\Module;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SampleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sample Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
/*Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'sampleModal',
    'size' => 'modal-lg',
    //'tabindex' => false
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'>This is a sample</div>";
Modal::end();*/
?>
<div class="sample-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php /*echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'rstl_id',
            //'pstcsample_id',
            //'package_id',
            //'sample_type_id',
            'sample_code',
            'samplename',
            [
                //'attribute' => 'request.request_datetime',
                'label' => 'Date Received',
                'format' => 'raw',
                'value' => function($data){ 
                	return Yii::$app->formatter->asDate($data->request->request_datetime, 'php:F j, Y');
                },
            ],
            [
                //'attribute' => 'request.request_datetime',
                'label' => 'Due Date',
                'format' => 'raw',
                'value' => function($data){ 
                	return Yii::$app->formatter->asDate($data->request->report_due, 'php:F j, Y');
                },
            ],
            //'description:ntext',
            // 'sampling_date',
            // 'remarks',
            //'request_id',
            [
                'attribute' => 'request_id',
                //'label' => 'Request Code',
                'format' => 'raw',
                'value' => function($data){ return $data->request->request_ref_num;},
            ],
            // 'sample_month',
            // 'sample_year',
            // 'active',
            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                            if (Yii::$app->user->identity->id != $model->sample_id) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['/lab/sample/update', 'id' => $model->sample_id,'request_id'=>$model->request_id]),
                                    [
                                        'title' => Yii::t('app', 'Update'),
                                        'data-pjax' => '0',
                                        'aria-label' => 'Update',
                                        'class' => 'btn btn-primary'
                                    ]
                                );
                            }
                        },
                ],
            ],
        ],
    ]);*/ ?>
<?php
    /*echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'panel'=>['type'=>'primary', 'heading'=>'Grid Grouping Example'],
    'columns'=>[
        ['class'=>'kartik\grid\SerialColumn'],
        [
            'attribute'=>'supplier_id', 
            'width'=>'310px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->supplier->company_name;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any supplier'],
            'group'=>true,  // enable grouping
        ],
        [
            'attribute'=>'category_id', 
            'width'=>'250px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->category->category_name;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any category'],
            'group'=>true,  // enable grouping
            'subGroupOf'=>1 // supplier column index is the parent group
        ],
        [
            'attribute'=>'product_name',
            'pageSummary'=>'Page Summary',
            'pageSummaryOptions'=>['class'=>'text-right text-warning'],
        ],
        [
            'attribute'=>'unit_price',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 2],
            'pageSummary'=>true,
            'pageSummaryFunc'=>GridView::F_AVG
        ],
        [
            'attribute'=>'units_in_stock',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true
        ],
        [
            'class'=>'kartik\grid\FormulaColumn',
            'header'=>'Amount In Stock',
            'value'=>function ($model, $key, $index, $widget) { 
                $p = compact('model', 'key', 'index');
                return $widget->col(4, $p) * $widget->col(5, $p);
            },
            'mergeHeader'=>true,
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 2],
            'pageSummary'=>true
        ],
    ],
]);*/

    $daterange = DateRangePicker::widget([
    'name'=>'date_range_1',
    'useWithAddon'=>true,
    //'language'=>$config['language'],             // from demo config
    //'hideInput'=>$config['hideInput'],           // from demo config
    //'presetDropdown'=>$config['presetDropdown'], // from demo config
    'pluginOptions'=>[
        //'locale'=>['format'=>$config['format']], // from demo config
        //'separator'=>$config['separator'],       // from demo config
        'opens'=>'left'
    ]
]);
    $filterbutton = Html::button('<i class="glyphicon glyphicon-search"></i> Search', ['value' => Url::to(['sample/create']),'title'=>'Search by Request Date', 'onclick'=>'searchRequestDate(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']);
    $daterange1 = '<label class="control-label">Filter by Request Date : </label> '.DateRangePicker::widget([
        'name'=>'date_range_3',
        //'value'=>'2015-10-19 - 2015-11-03',
        'value' => date("Y-m-d")." - ".date("Y-m-d"),
        'convertFormat'=>true,
        'options'=>[
            'style' => 'width:15%;padding:5px;',
        ],
        'pluginOptions'=>[
            //'timePicker'=>true,
            //'timePickerIncrement'=>15,
            //'locale'=>['format'=>'Y-m-d h:i A']
            'timePicker'=>false,
            'locale'=>['format'=>'Y-m-d'],
        ]            
    ]);
  /*  echo ExportMenu::FORMAT_EXCEL_X => [
            'label' => 'Excel 2007+',
            //'icon' => $isFa ? 'file-excel-o' : 'floppy-remove',
            'iconOptions' => ['class' => 'text-success'],
            'linkOptions' => [],
            'options' => ['title' => 'Microsoft Excel 2007+ (xlsx)'],
            'alertMsg' => 'The EXCEL 2007+ (xlsx) export file will be generated for download.',
            'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'extension' => 'xlsx',
            'writer' => ExportMenu::FORMAT_EXCEL_X
        ];*/

echo GridView::widget([
    'dataProvider'=>$dataProvider,
    //'filterModel'=>$searchModel,
    //'showPageSummary'=>true,
    'showPageSummary'=>false,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'panel'=>[
        'type'=>'primary', 
        'heading'=>'Sample Register',
        //'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Sample', ['value' => Url::to(['sample/create','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn'])." ".Html::button('<i class="glyphicon glyphicon-plus"></i> Generate Samplecode', ['value' => Url::to(['sample/generatesamplecode','request_id'=>$model->request_id]),'title'=>'Add Sample', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
        'before'=>$daterange1." ".$filterbutton,
    ],
    'exportConfig' => [
        //GridView::CSV => ['label' => 'Save as CSV'],
        //GridView::HTML => [],
        GridView::PDF => [],
        GridView::EXCEL => [
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
            'mime' => 'application/vnd.ms-excel',
            'config' => [
                'worksheet' => $this->title,
                'cssFile' => ''
            ]
        ],
        GridView::EXCEL => [
            'label' => 'Excel',
            //'icon' => 'file-excel-o',
            'iconOptions' => ['class' => 'text-success'],
            'showHeader' => true,
            'showPageSummary' => true,
            'showFooter' => true,
            'showCaption' => true,
            //'filename' => $this->title,
            'alertMsg' => 'The EXCEL export file will be generated for download.',
            'options' => ['title' => 'Microsoft Excel 95+'],
            'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'extension' => 'xlsx',
            //'writer' => ExportMenu::FORMAT_EXCEL_X,
            'config' => [
                'worksheet' => $this->title,
                'cssFile' => ''
            ]
        ],
    ],
    'columns'=>[
        //['class'=>'kartik\grid\SerialColumn'],
        [
            'attribute'=>'sample_code', 
            //'width'=>'310px',
            /*'value'=>function ($model, $key, $index, $widget) { 
                return $model->supplier->company_name;
            },*/
            // 'filterType'=>GridView::FILTER_SELECT2,
            // 'filter'=>ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'), 
            // 'filterWidgetOptions'=>[
            //     'pluginOptions'=>['allowClear'=>true],
            // ],
            // 'filterInputOptions'=>['placeholder'=>'Any supplier'],
            'label' => 'Sample Code',
            'format' => 'raw',
            'value' => function($model, $key, $index, $widget){
            	//return Yii::$app->formatter->asDate($model->request->request_datetime, 'php:F j, Y');
            	return $model->sample->sample_code;
            },
            'group'=>true,  // enable grouping
        ],
        [
        	'attribute' => 'request.request_datetime',
            'label' => 'Date Received',
            //'filterType'=> GridView::FILTER_DATE_RANGE,
            'format' => 'raw',
            'value' => function($model, $key, $index, $widget){
            	//return Yii::$app->formatter->asDate($model->request->request_datetime, 'php:F j, Y');
            	return Yii::$app->formatter->asDate($model->sample->request->request_datetime, 'php:Y-m-d');
            },
            //'attribute'=>'category_id', 
            'width'=>'250px',
            // 'value'=>function ($model, $key, $index, $widget) { 
            //     return $model->category->category_name;
            // },
            // 'filterType'=>GridView::FILTER_SELECT2,
            // 'filter'=>ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'), 
            // 'filterWidgetOptions'=>[
            //     'pluginOptions'=>['allowClear'=>true],
            // ],
            // 'filterInputOptions'=>['placeholder'=>'Any category'],
            'group'=>true,  // enable grouping
            //'subGroupOf'=>1 // supplier column index is the parent group
        ],
        [
        	'attribute' => 'request.report_due',
            'label' => 'Report Due Date',
            'format' => 'raw',
            'value' => function($model, $key, $index, $widget){
            	return Yii::$app->formatter->asDate($model->sample->request->report_due, 'php:Y-m-d');
            },
            'group'=>true,  // enable grouping
        ],
        /*[
           'attribute'=>'request.report_due',
           'filterType'=> GridView::FILTER_DATE_RANGE,
           // 'value' => function($model) {
           //      return date_format(date_create($model->order_date),"m/d/Y");
           //  },
            'value' => function($model, $key, $index, $widget){
                return Yii::$app->formatter->asDate($model->sample->request->report_due, 'php:Y-m-d');
            },
            'filterWidgetOptions' => ([
                 'model'=>$model,
                 'useWithAddon'=>true,
                 'attribute'=>'request.report_due',
                 'startAttribute'=>'createDateStart',
                 'endAttribute'=>'createDateEnd',
                 'presetDropdown'=>TRUE,
                 'convertFormat'=>TRUE,
                 'pluginOptions'=>[
                     'allowClear' => true,
                    'locale'=>[
                        'format'=>'Y-m-d',
                        'separator'=>' to ',
                    ],
                     'opens'=>'left',
                  ],
                 'pluginEvents'=>[
                    "cancel.daterangepicker" => "function(ev, picker) {
                    picker.element[0].children[1].textContent = '';
                    $(picker.element[0].nextElementSibling).val('').trigger('change');
                    }",
                    
                    'apply.daterangepicker' => 'function(ev, picker) { 
                    var val = picker.startDate.format(picker.locale.format) + picker.locale.separator +
                    picker.endDate.format(picker.locale.format);

                    picker.element[0].children[1].textContent = val;
                    $(picker.element[0].nextElementSibling).val(val);
                    }',
                  ] 
                 
            ]),        
           
        ],*/
        [
            'attribute'=>'samplename',
            //'pageSummary'=>'Page Summary',
            //'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            //'attribute' => 'request.report_due',
            'label' => 'Sample Name',
            'format' => 'raw',
            //'filterType' => GridView::FILTER_SELECT2,
            /*'value' => function($model, $key, $index, $widget){
            	return $model->sample->samplename;
            },*/
            'value'=>'sample.samplename',
            'group'=>true,  // enable grouping
        ],
        [
            'attribute'=>'testname',
            //'pageSummary'=>'Page Summary',
            //'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            //'attribute' => 'request.report_due',
            'label' => 'Parameters',
            'format' => 'raw',
            // 'value' => function($model, $key, $index, $widget){
            // 	return $model->sample->samplename;
            // },
        ],
        [
            //'attribute'=>'testname',
            'attribute'=>'start_date',
            //'pageSummary'=>'Page Summary',
            //'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            //'attribute' => 'request.report_due',
            'label' => 'Date Analysis Started',
            'format' => 'raw',
            'value' => 'tagging.start_date',
            //'value' => function($model, $key, $index, $widget){
            	//return Yii::$app->formatter->asDate($model->taggings->start_date, 'php:Y-m-d');
            	//return $model->taggings->analysis_id;
            	//return Analysis::findOne($model->analysis_id)->taggings->start_date;
            	//$id = $model->analysis_id;
            //	$tagging = Analysis::findOne($model->analysis_id)->taggings;
            //	return $tagging['start_date'];
            	//return $b['start_date'];

            //},
        ],
        [
            //'attribute'=>'testname',
            'attribute'=>'end_date',
            //'pageSummary'=>'Page Summary',
            //'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            //'attribute' => 'request.report_due',
            'label' => 'Analysis Due Date',
            'format' => 'raw',
            'value' => 'tagging.end_date',
            //'value' => function($model, $key, $index, $widget){
            	//return Yii::$app->formatter->asDate($model->taggings->end_date, 'php:Y-m-d');
            	//return $model->taggings->analysis_id;
            //	$tagging = Analysis::findOne($model->analysis_id)->taggings;
            	//return $tagging['end_date'];
           // },
        ],
        [
            //'attribute'=>'testname',
            //'pageSummary'=>'Page Summary',
            //'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            //'attribute' => 'request.report_due',
            'label' => 'Date Sample Disposed',
            'format' => 'raw',
            //'value' => function($model, $key, $index, $widget){
            	//return Yii::$app->formatter->asDate($model->taggings->end_date, 'php:Y-m-d');
            	//return $model->taggings->analysis_id;
            //	$tagging = Analysis::findOne($model->analysis_id)->taggings;
            	//return $tagging['disposed_date'];
            	//return $model->taggings->analysis_id;
            	//echo "<pre>";
            	//print_r($model->taggings->disposed_date);
            	//echo "</pre>";
            	//return Analysis::findOne($model->analysis_id)->taggings->disposed_date;
            //},
            'value'=>'tagging.disposed_date',
            // 'value' => function($data){
            // 	echo "<pre>";
            // 	print_r($data->taggings->start_date);
            // 	echo "</pre>";
            // },
        ],
        [
            //'attribute'=>'testname',
            //'pageSummary'=>'Page Summary',
            //'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            'attribute' => 'tagging.manner_disposal',
            //'label' => 'Manner of Disposal',
            'format' => 'raw',
            'value' => 'tagging.manner_disposal',
            //'value' => function($model, $key, $index, $widget){
            	//return Yii::$app->formatter->asDate($model->taggings->end_date, 'php:Y-m-d');
            	//return $model->taggings->analysis_id;
            	//$tagging = Analysis::findOne($model->analysis_id)->taggings;
            	//return $tagging['disposed_date'];
            	//return $model->taggings->analysis_id;
            	//echo "<pre>";
            	//print_r($model->taggings->disposed_date);
            	//echo "</pre>";
            	//return Analysis::findOne($model->analysis_id)->taggings->disposed_date;
           // },
            // 'value' => function($data){
            // 	echo "<pre>";
            // 	print_r($data->taggings->start_date);
            // 	echo "</pre>";
            // },
        ],
        [
            //'attribute'=>'testname',
            //'pageSummary'=>'Page Summary',
            //'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            //'attribute' => 'request.report_due',
            'label' => 'Analyst',
            'format' => 'raw',
            //'value'=> SampleregisterUser::getUser($data->taggings->user_id),
            'value' => function($model){
            	//return Yii::$app->formatter->asDate($model->taggings->end_date, 'php:Y-m-d');
            	//return $model->taggings->analysis_id;
            	//$tagging = Analysis::findOne($model->analysis_id)->taggings;
            	//return $tagging['disposed_date'];
            	//return $model->taggings->analysis_id;
            	//echo "<pre>";
            	//print_r($model->taggings->disposed_date);
            	//echo "</pre>";
            	//return Analysis::findOne($model->analysis_id)->taggings->disposed_date;
           // },
            // 'value' => function($data){
            // 	echo "<pre>";
            // 	print_r($data->taggings->start_date);
            // 	echo "</pre>";
                //return $model->taggings->user_id;
                $tagging = $model->tagging;
                return SampleregisterUser::getUser($tagging['user_id']);
                //return $tagging['user_id'];
                
               /* echo "<pre>";
                print_r($model->taggings);
                echo "</pre>";*/
            },
        ],
        /*[
            'attribute'=>'unit_price',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 2],
            'pageSummary'=>true,
            'pageSummaryFunc'=>GridView::F_AVG
        ],
        [
            'attribute'=>'units_in_stock',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true
        ],*/
        /*[
            'class'=>'kartik\grid\FormulaColumn',
            'header'=>'Amount In Stock',
            'value'=>function ($model, $key, $index, $widget) { 
                $p = compact('model', 'key', 'index');
                return $widget->col(4, $p) * $widget->col(5, $p);
            },
            'mergeHeader'=>true,
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 2],
            'pageSummary'=>true
        ],*/
    ],
]);
?>
        </div>
</div>
</div>

<script type="text/javascript">
//$.fn.modal.Constructor.prototype.enforceFocus = $.noop;
    $("#modalBtn").click(function(){
        $(".modal-title").html($(this).attr('title'));
        $("#modal").modal('show')
        //$("#sampleModal").modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });

    function searchRequestDate()
    {

    }

    function searchRequestDate(id){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       var url = '/lab/sample/update?id='+id;
        $('.modal-title').html('Update Sample');
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
</script>
