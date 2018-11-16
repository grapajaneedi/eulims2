<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\inventory\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$JS=<<<SCRIPT
    function ShowModal(){
        $("#modalHeader").show();
    }
SCRIPT;
//$this->registerJs($JS);
$this->registerJs($search);
Modal::begin([
    'id' => 'modalHeader',
    'header' => '<h4 class="modal-title">Details</h4>',
]);
//$modalContent=$this->render('_form',['model'=>$searchModel]);
Modal::end();
?>
<div class="products-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php 
   
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        'product_id',
        'product_code',
        'product_name',
        'description:ntext',
        'price',
        'srp',
        [
                'attribute' => 'category_type_id',
                'label' => 'Category Type',
                'value' => function($model){                   
                    return $model->categorytype->categorytype;                   
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(\common\models\inventory\Categorytype::find()->asArray()->all(), 'categorytype_id', 'categorytype'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Categorytype', 'id' => 'grid-products-search-category_type_id']
        ],
        'qty_reorder',
        'qty_onhand',
        'qty_min_reorder',
        'qty_per_unit',
        'discontinued:boolean',
        [
            "label" => "Suppliers",
            "format" => 'raw',
            "value" => function($model){
                return Html::button('<span class="glyphicon glyphicon-eye"></span> Suppliers', ['value'=>'/inventory/products/supplier?ids='.$model->suppliers_ids, 'class' => 'btn btn-success','title' => Yii::t('app', "List of Supplier(s)"),'id'=>'btnSupplier','onclick'=>'showBonus(this.value,this.title)']);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'before'=>Html::button('<span class="glyphicon glyphicon-plus"></span> Create Product', ['value'=>'/inventory/products/create', 'class' => 'btn btn-success','title' => Yii::t('app', "Create New Product"),'id'=>'btnProd','onclick'=>'addProduct(this.value,this.title)']),
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
            ]) ,
        ],
    ]); ?>

</div>
<script type="text/javascript">
    function showBonus(url,title){
        LoadModal(title,url,'true','700px');
    }
    function addProduct(url,title){
        LoadModal(title,url,'true','800px');
    }
</script>
