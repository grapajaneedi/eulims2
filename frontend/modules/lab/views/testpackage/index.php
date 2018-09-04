<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Methodreference;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\TestpackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Testpackages';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $this->registerJsFile("/js/services/services.js"); ?>

<div class="testpackage-index">


    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test Package', ['value'=>'/lab/testpackage/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Test Package")]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            'lab_sampletype_id',
            'package_name',
            'package_rate',
            'testname_methods',
            'added_by',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
           'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/testpackage/view','id'=>$model->testpackage_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Test Package<font color='Blue'></font>")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/testpackage/update','id'=>$model->testpackage_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Test Package<font color='Blue'></font>")]);
                },
                'delete'=>function ($url, $model) {
                    $urls = '/lab/testpackage/delete?id='.$model->testpackage_id;
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Test Package','data-pjax'=>'0']);
                },
                ],
            ],
        ],
    ]); ?>
</div>
