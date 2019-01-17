<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\helpers;

/* @var $this yii\web\View */
/* @var $searchModel common\models\api\YiiMigrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Yii Migrations';
$this->params['breadcrumbs'][] = $this->title;
$Button="{view}{update}";
?>
<div class="yii-migration-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Yii Migration', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'id'=>'yii-grid',
        'pjax' => true,
      //  'showPageSummary' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> "<b>OP: </b>".$op."<b><br>Paymentitem:</b>".$paymentitem."<b><br>Receipt: </b>".$receipt."<b><br>Deposit: </b>".$deposit,
                'after'=>false,
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tblname',
            'num',
            'ids',

            [   'class' => kartik\grid\ActionColumn::className(),
                'template' => $Button,
                'buttons' => [
                    'view'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-upload"></span> Sync Up', ['value'=>'/finance/updb/sync?tblname='.$model->tblname, 'onclick'=>'ShowModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "Sync</font>")]);
                    },
                     'update'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span> Edit', ['value'=>'/finance/updb/update?id='.$model->id, 'onclick'=>'ShowModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update</font>")]);
                    },        
                ]
            ],
            
        ],
    ]); ?>
</div>
