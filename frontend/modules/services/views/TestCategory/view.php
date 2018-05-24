<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\TestCategory */

$this->title = $model->testcategory_id;
// $this->params['breadcrumbs'][] = ['label' => 'Test Categories', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'testcategory_id',
            'category_name',
            'lab.labname',
        ],
    ]) 
    ?>
    </div>  
    <?php if(Yii::$app->request->isAjax){ ?>
    <div style="position:absolute;right:18px;bottom:10px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
    <?php } ?>
    <!-- </div> -->
</div>
