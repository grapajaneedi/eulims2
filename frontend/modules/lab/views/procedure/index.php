<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\ProcedureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procedures';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>Sample Name:</b> Please scan barcode in the dropdown list below. .</p>
     
    </div>
<div class="procedure-index">

 
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
                'before'=>  Html::button('<span class="glyphicon glyphicon-plus"></span> Create Procedure', ['value'=>'/lab/procedure/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Procedure")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'procedure_name',
            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
            'template' => '{update}',
           
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/procedure/view','id'=>$model->procedure_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Procedure <font color='Blue'></font>")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/procedure/update','id'=>$model->procedure_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Procedure<font color='Blue'></font>")]);
                },
                'delete'=>function ($url, $model) {
                    $urls = '/lab/procedure/delete?id='.$model->procedure_id;
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Procedure','data-pjax'=>'0']);
                },
            ],
        ],
        ],
    ]); ?>
</div>
