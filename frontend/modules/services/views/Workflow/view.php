<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\services\Workflow */

$this->title = $model->workflow_id;
$this->params['breadcrumbs'][] = ['label' => 'Workflows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workflow-view">

 

    <p>
      
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'workflow_id',
            'test.testName',
            'method',
            'workflow',
        ],
    ]) ?>

    <div style="position:absolute;right:18px;bottom:10px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
</div>
