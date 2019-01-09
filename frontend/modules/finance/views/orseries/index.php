<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\models\finance\Orcategory;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\OrseriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


use common\components\Functions;

$func= new Functions();
$this->title = 'OR Series';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = 'OR Series';

$Header="Department of Science and Technology<br>";
$Header.="O.R Series";
?>
<div class="table-responsive">
    <?php 
    $Buttontemplate='{update}{delete}'; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'before'=>Html::button('<span class="glyphicon glyphicon-plus"></span> Create O.R Series', ['value'=>'/finance/orseries/create', 'class' => 'btn btn-success','title' => Yii::t('app', "Create New O.R Series"),'id'=>'btnOrseries','onclick'=>'addOrseries(this.value,this.title)']),
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'exportConfig'=>$func->exportConfig("Orseries", "orseries", $Header),
        
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'or_category_id',
                    'label' => 'Category',
                    'value' => function($model) {
                        return $model->orcategory->category;
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map(Orcategory::find()->asArray()->all(), 'or_category_id', 'category'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Collection Type', 'id' => 'grid-op-search-category']
                ],
                'or_series_name',
                'startor',
                'nextor',
                'endor',           
                [
                    'class' => kartik\grid\ActionColumn::className(),
                    'template' => $Buttontemplate,
                    'buttons'=>[
                    'update'=>function ($url,$model) {
                        $t = '/finance/orseries/update?id='.$model->or_series_id;
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-success btn-modal']);
                    },
                    
                ],
                ],
            ],
                       
    ]); ?>
</div>
<script type="text/javascript">
    $('#btnOrseries').click(function(){
        $('.modal-title').html($(this).attr('title'));
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
    function addOrseries(url,title){
        LoadModal(title,url,'true','700px');
    }
  
</script>