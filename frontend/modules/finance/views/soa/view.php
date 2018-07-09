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
            'before'=>""
        ],
        'rowOptions'=>function($model){
            if($model->payment_due_date<date("Y-m-d")){
                return ['style' => 'color: gray;font-weight: regular'];
            }elseif($model->active==1){
                return ['style' => 'color: gray;font-weight: bold'];
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
        <div class="form-group pull-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
