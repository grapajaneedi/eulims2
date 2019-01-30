<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\progress;
use common\models\lab\CustomerMigration;
use common\models\api\CustomerMigrationportal;


/* @var $this yii\web\View */
/* @var $searchModel common\models\api\MigrationportalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Migrationportals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migrationportal-index">
    
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
             <h4><i class="icon fa fa-check"></i>Saved!</h4>
             <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
             <h4><i class="icon fa fa-warning"></i>Note!</h4>
             <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <h1>Yii 1.0 to 2.0 Migration [Ulimsportal Only]</h1>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'before'=>Html::button('<span class="glyphicon glyphicon-plus"></span> Create Job', ['value'=>'/api/migrationportal/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create New Job")]),
                'heading' => '<span class="glyphicon glyphicon-hand"></span>  ' . Html::encode($this->title),
         ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'isdone',
                'header'=>'Status',
                'value'=>function($model){
                    if($model->isdone==0){
                        return "Pending Job";
                    }elseif($model->isdone==1){
                        return "Performed Job";
                    }
                }
            ],
            [
                'attribute' => 'job_type',
                'value' => function($model){     
                    switch($model->job_type){
                        case '0':
                        return "BackUp Yii 1.0 DB";
                        break;
                        case '1':
                        return "Perform DB Link";
                        break;
                        case '2':
                        return "Posting DB to Yii 2.0";
                        break;
                        default:
                        return "Unknown Job Type";
                        break;
                    }             
                },
            ],
            'remarks:ntext',
            'logs:ntext',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?php 
$this->registerCssFile("/css/modcss/migrationportal.css", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'css-search-bar');
?>