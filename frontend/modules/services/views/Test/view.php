<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\lab\Lab;
use common\models\services\Testcategory;
use common\models\services\Sampletype;

/* @var $this yii\web\View */
/* @var $model common\models\services\Test */

$this->title = $model->test_id;
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-view">


  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'test_id',
            'agency_id',
            'testname',
            'method',
            'references',
            'fee',
            'duration',
            'testCategory.category_name',
            'sampleType.sample_type'
        ],
    ]) ?>

<div style="position:absolute;right:18px;bottom:10px;">
    <!-- <div class="pull-right" style="text-align:right;position:relative;"> -->
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
</div>
