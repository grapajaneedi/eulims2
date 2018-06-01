<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use kartik\grid\DataColumn;


/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\AccountingcodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounting Codes';
$this->params['breadcrumbs'][] = $this->title;

$Buttontemplate ='{view}{update}';
?>
<style type="text/css">
    .kv-grouped-row {
    background-color: #8CB9E3!important;
    font-size: 1.2em;
    padding-top: 10px!important;
    padding-bottom: 10px!important;
    font-weight: bold;
    font-family: 'Source Sans Pro',sans-serif;
}
</style>



<div class="accountingcode-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
       
    <p>
      
         <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Accounting Code', ['value'=>'/finance/accountingcode/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create Accounting Code"),'name'=>'Create Accounting Code']); ?>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span>Account Code Mapping', ['value'=>'/finance/accountingcodemapping/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Account Code Mapping"),'name'=>'Account Code Mapping']); ?>
      
    </p>
    
   
      
        

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'panel'=>['type'=>'primary', 'heading'=>'Account Code Mapping'],
       // 'filterModel' => $searchModel,
            'columns' => [
                    ['class'=>'kartik\grid\SerialColumn'],
                    [
                    'attribute' => 'accountcode',
                    
                    'group' => true, // enable grouping
                    'groupedRow'=>true,                    // move grouped column to a single grouped row
                    'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                    'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
                ],
            [
                'attribute' =>  'natureofcollection',
                'header' => 'Collection Type',
                'subGroupOf'=>0
                ]
            ],
    ]); ?>
</div>
