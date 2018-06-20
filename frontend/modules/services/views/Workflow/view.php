<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\services\Procedure;

/* @var $this yii\web\View */
/* @var $model common\models\services\Workflow */

$this->title = $model->workflow_id;
$this->params['breadcrumbs'][] = ['label' => 'Workflows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workflow-view">

 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'workflow_id',
            'test.testname',
            'method',
            // 'workflow',
        ],
    ]) ?>


    <ul class="timeline">

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-green">
            Start of Workflow
        </span>
    </li>
    <!-- /.timeline-label -->

    <?php
    $steps= explode(',', $model->workflow);
    $n=0;
    foreach ($steps as $s) {
        $n++;
        $var = Procedure::findOne($s);
        echo '<li>
                <i class="fa fa-exclamation bg-blue"></i>
                 <div class="timeline-item">
                    <span class="time"><i class="fa fa-map-o"> '.$n.'</i></span>';
        if($var)
            echo '<h3 class="timeline-header"><a href="#">'.$var->procedure_code.'</a></h3>';
        else
            echo '<h3 class="timeline-header"><a href="#">"Error: Test ID not found"</a> ...</h3>';

        echo '              <div class="timeline-body">
                            '.$var->procedure_name.'
                        </div>
                    </div>
              </li>'; 
    }


    ?>
    <!-- timeline item -->

    <li class="time-label">
        <span class="bg-red">
            End of Workflow
        </span>
    </li>
    <!-- END timeline item -->

</ul>

    <div style="position:absolute;right:18px;bottom:10px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
</div>