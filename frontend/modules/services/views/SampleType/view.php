<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\services\Sampletype */

$this->title = $model->sample_type_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sampletype-view">

    <p>
       
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sample_type_id',
            'sample_type',
            'testCategory.category_name',
        ],
    ]) ?>

<div style="position:absolute;right:18px;bottom:10px;">
    <!-- <div class="pull-right" style="text-align:right;position:relative;"> -->
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
</div>
