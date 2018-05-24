<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\AccountingcodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounting Codes';
$this->params['breadcrumbs'][] = $this->title;

$Buttontemplate ='{view}{update}';
?>
<div class="accountingcode-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
       
    <p>
      
         <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Accounting Code', ['value'=>'/finance/accountingcode/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create Accounting Code"),'name'=>'Create Accounting Code']); ?>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span>Account Code Mapping', ['value'=>'/finance/accountingcodemapping/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Account Code Mapping"),'name'=>'Account Code Mapping']); ?>
        
    </p>
    
   
      
        

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'accountcode',
            'accountdesc',
            [
             'class' => 'yii\grid\ActionColumn',
              //'class' => kartik\grid\ActionColumn::className(),
             'template' => '{view}{update}',
             'buttons'=>[
                    'view'=>function ($url, $model) {
                        $urlAccountCodeView = '/finance/accountingcode/view?id='.$model->accountingcode_id;
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to($urlAccountCodeView), 'class' => 'btn btn-primary btn-modal','title' => Yii::t('app', "View Accounting Code"),'name'=>'View Accounting Code']);
                     
                    },
                    'update'=>function ($url, $model) {
                        $urlAccountCodeUpdate = '/finance/accountingcode/update?id='.$model->accountingcode_id;
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to($urlAccountCodeUpdate), 'class' => 'btn btn-primary btn-modal','title' => Yii::t('app', "Update Accounting Code"),'name'=>'Update Accounting Code']);
                    },
                   
                ],
                            
              ],
            
        ],
    ]); ?>
</div>
