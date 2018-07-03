    <?php

use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use common\components\Functions;
$func= new Functions();

/* @var $this yii\web\View */
/* @var $searchModel common\models\services\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tests';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['/services']];
$this->params['breadcrumbs'][] = 'Manage Test';

//$this->params['breadcrumbs'][] = 'Test Categories';
$this->registerJsFile("/js/services/services.js");
?>
<div class="test-index">

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test', ['value'=>'/services/test/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create New Test"),'name' => Yii::t('app', "Create New Test")]); ?>
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

           // 'test_id',
            // 'rstl_id',
            'testname',
            'method',
            'payment_references',
            'fee',
            'duration',
            // 'test_category_id',
            // 'sample_type_id',
            // 'lab_id',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
           // 'visible'=> Yii::$app->user->isGuest ? false : true,
            'template' => '{view}{update}{workflow}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    $t = '/services/testcategory/create';
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/services/test/view?id='.$model->test_id, 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary btn-modal','title' => Yii::t('app', "View Test"),'name' => Yii::t('app', "View Test")]);
                },
                'update'=>function ($url, $model) {
                    $t = '/services/testcategory/create';
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/services/test/update?id='.$model->test_id,'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Update Test"),'name' => Yii::t('app', "Update Test<font color='Blue'></font>")]);
                },
                'workflow'=>function ($url, $model) {
                    $t = '/services/workflow/create?test_id='.$model->test_id;

                    if($model->workflow){
                        $t = '/services/workflow/view?id='.$model->workflow->workflow_id;
                        return Html::button('<span class="glyphicon glyphicon-search"></span><span class="glyphicon glyphicon-file"></span>', ['value'=>$t, 'class' => 'btn btn-danger btn-modal','name' => Yii::t('app', "Workflow"),'title' => Yii::t('app', "View  Workflow")]);
                    }
                    else
                        return Html::button('<span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-file"></span>', ['value'=>$t, 'class' => 'btn btn-danger btn-modal','name' => Yii::t('app', "Workflow"),'title' => Yii::t('app', "Create Workflow")]);
                },

            ],
        ],
        ],
    ]); ?>
</div>
<?php
    // This section will allow to popup a notification
    $session = Yii::$app->session;
    if ($session->isActive) {
        $session->open();
        if (isset($session['deletemessage'])) {
            $sweetalert->CrudAlert("Successfully Deleted","WARNING",true);
            unset($session['deletemessage']);
            $session->close();
        }
        if (isset($session['updatemessage'])) {
            $sweetalert->CrudAlert("Successfully Updated","SUCCESS",true);
            unset($session['updatemessage']);
            $session->close();
        }
        if (isset($session['savemessage'])) {
            $sweetalert->CrudAlert("Successfully Saved","SUCCESS",true);
            unset($session['savemessage']);
            $session->close();
        }
        if (isset($session['cancelmessage'])) {
            $sweetalert->CrudAlert("Successfully Cancelled","WARNING",true);
            unset($session['cancelmessage']);
            $session->close();
        }
        if (isset($session['requestmessage'])) {
            $sweetalert->CrudAlert("Successfully Generated Reference Number and Sample Code","WARNING",true);
            unset($session['requestmessage']);
            $session->close();
        }
    }
?>