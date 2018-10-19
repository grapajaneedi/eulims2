<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Lab;
use common\models\lab\Sampletype;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\PackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$sampetypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');

$this->title = 'Packages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-index">

 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
    <?php $this->registerJsFile("/js/services/services.js"); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> Html::button("<span class='glyphicon glyphicon-plus'></span> Create Package", ["value"=>"/lab/package/create", "class" => "btn btn-success modal_services","title" => Yii::t("app", "Create Package")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
           // 'rstl_id',
           
            [
                'attribute' => 'sampletype_id',
                'label' => 'Sample Type',
                'value' => function($model) {

                    if ($model->sampletype){
                        return $model->sampletype->type;
                    }else{
                        return "";
                    }
                    
                },
               'filterType' => GridView::FILTER_SELECT2,
               'filter' => $sampetypelist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
               ],
               'filterInputOptions' => ['placeholder' => 'Sample Type', 'testcategory_id' => 'grid-products-search-category_type_id']
            ],
            'name',
            'rate',
            'tests',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
            'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/labsampletype/view','id'=>$model->id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Lab Sample Type <font color='Blue'></font>")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/labsampletype/update','id'=>$model->id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Lab Sample Type<font color='Blue'></font>")]);
                },
                'delete'=>function ($url, $model) {
                    $urls = '/lab/labsampletype/delete?id='.$model->id;
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Lab Sample Type','data-pjax'=>'0']);
                },
            ],
        ],
        ],
    ]); ?>
</div>
