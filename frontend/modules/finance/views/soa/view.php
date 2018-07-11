<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\DetailView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $model common\models\finance\BillingReceipt */

$this->title = "SOA";
$this->params['breadcrumbs'][] = ['label' => 'Statement of Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//$model=$dataProvider->getModels();
$pdfHeader="DOST-IX Enhanced ULIMS";
$pdfFooter="{PAGENO}";
$html=<<<HTML
<fieldset class="legend-border">
    <legend class="scheduler-border">Legends</legend>
    <div class="control-group">
        <div class="row">
            <div class="col-md-2">
                <label>Current SOA:</label>
            </div>
            <div class="col-md-1">
                <span class="badge badge-success" style="background-color: green;width: 40px;height: 15px">&nbsp;</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Previous SOA:</label>
            </div>
            <div class="col-md-1">
                <span class="badge badge-default" style="background-color: gray;width: 40px;height: 15px">&nbsp;</span>
            </div>
        </div>
    </div>
</fieldset>       
HTML;
?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'hover' => true,
        'striped'=>true,
        'showPageSummary' => true,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'exportConfig'=>[
            GridView::PDF => [
                'filename' => 'statement_of_account',
                'alertMsg'        => 'The PDF export file will be generated for download ok dudz.',
                'config' => [
                    'methods' => [
                        'SetHeader' => [$pdfHeader],
                        'SetFooter' => [$pdfFooter]
                    ],
                    'options' => [
                        'title' => 'Statement of Account',
                        'subject' => 'SOA',
                        'keywords' => 'pdf, preceptors, export, other, keywords, here'
                    ],
                ]
            ],
            GridView::EXCEL => [
                'label'           => 'Excel',
                //'icon'            => 'file-excel-o',
                'methods' => [
                    'SetHeader' => [$pdfHeader],
                    'SetFooter' => [$pdfFooter]
                ],
                'iconOptions'     => ['class' => 'text-success'],
                'showHeader'      => TRUE,
                'showPageSummary' => TRUE,
                'showFooter'      => TRUE,
                'showCaption'     => TRUE,
                'filename'        => "statement of account",
                'alertMsg'        => 'The EXCEL export file will be generated for download.',
                'options'         => ['title' => 'Department of Science OneLab'],
                'mime'            => 'application/vnd.ms-excel',
                'config'          => [
                    'worksheet' => 'Statement of Account',
                    'cssFile'   => ''
                ]
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' =>"<span class='fa fa-user-o'></span> Account: " . $model->customer_name,
            'before'=>"",
            'after'=>$html
        ],
        'rowOptions'=>function($model){
            if($model->payment_due_date<date("Y-m-d")){
                return ['style' => 'background-color: gray;font-weight: regular;color: white'];
            }elseif($model->active==1){
                return ['style' => 'background-color: green;font-weight: bold;color: white'];
            }
        },
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute'=>'soa_date',
                'label'=>'Date',
                'hAlign' => 'center',
                'value'=>function($model){
                    return date("m/d/Y",strtotime($model->soa_date));
                }
            ],
            [
                'attribute'=>'payment_due_date',
                'label'=>'Due Date',
                'hAlign' => 'center',
                'value'=>function($model){
                    return date("m/d/Y",strtotime($model->payment_due_date));
                }
            ],
            [
                'attribute'=>'soa_number',
                'hAlign' => 'center',
            ],
            [
                'attribute'=>'previous_balance',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
            ],
            [
                'attribute'=>'current_amount',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
            ], 
            [
                'attribute'=>'payment_amount',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
            ],      
            [
                'attribute'=>'total_amount',
                'label'=>'Total',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
            ]
        ],
    ]); ?>
        <div class="form-group pull-right" style="font-family: monospace">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
