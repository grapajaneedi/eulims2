<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\MethodreferenceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Method References';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="methodreference-index">

<?php $this->registerJsFile("/js/services/services.js"); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Method Reference', ['value'=>'/lab/methodreference/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Method Reference")]); ?>
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
            ['class' => 'yii\grid\SerialColumn'],
            'method',
            'reference',
            'fee',
            //'create_time',
            //'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
