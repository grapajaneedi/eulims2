
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>

        <?= GridView::widget([
        'dataProvider' => $workflowdataprovider,
        'pjax' => true,
        'id'=>'workflow-grid',
        'containerOptions'=>[
            'style'=>'overflow:auto; height:320px',
        ],
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header'=>'Workflow Steps',
                'format' => 'raw',
                'width' => '80%',
                'enableSorting' => false,
                'value' => function($model) {
                    return $model->procedure_name;
                },
                'contentOptions' => ['style' => 'width:300px; white-space: normal;'],                      
            ],
           
        ],
    ]); ?>    