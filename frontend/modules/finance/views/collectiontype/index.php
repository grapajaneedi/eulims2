<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\CollectiontypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collection Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collectiontype-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Collection Type', ['value'=>'/finance/collectiontype/create', 'class' => 'btn btn-success btn-modal','name' => Yii::t('app', "Create New Collection Type")]); ?>
      
    </p>
    <div class="table-responsive">
        <?php 
        $Buttontemplate='{view}{update}{delete}'; 
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

               // 'collectiontype_id',
                'natureofcollection',
                'status',

                [
                    'class' => kartik\grid\ActionColumn::className(),
                    'template' => $Buttontemplate,
                ],
            ],
        ]); ?>
    </div>
</div>
