<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\modules\admin\components\Helper;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
$Header="Department of Science and Technology<br>";
$Header.="User Profile List";
?>
<div class="user-index">
    <?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => 'user']); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="fa fa-users"></span>  ' . Html::encode($this->title),
            'before'=>Html::a(Yii::t('rbac-admin', 'Signup New User'), ['signup'], ['class' => 'btn btn-success',])
        ],
        'exportConfig'=>$func->exportConfig("Laboratory Request", "laboratory request", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            'created_at:date',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 0 ? 'Inactive' : 'Active';
                },
                'filter' => [
                    0 => 'Inactive',
                    10 => 'Active'
                ]
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' =>"{view}{update}{delete}", //Helper::filterActionColumn(['view', 'activate', 'delete','update']),
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/admin/user/view?id='.$model->user_id, 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Profile")]);
                    },
                    'update'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/admin/user/update?id='.$model->user_id,'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Profile")]);
                    },
                    'delete'=>function($url, $model){
                        if($model->status ==0){
                           $msg="Activate";
                        }else{
                           $msg="Deactivate";
                        }
                        return Html::a("<span class='glyphicon glyphicon-trash'></span>", "/admin/user/deactivate?id=".$model->user_id, [
                            "title"=>"Deactivate", 
                            "aria-label"=>"Delete",
                            "data-pjax"=>"0", 
                            "data-method"=>"post", 
                            "data-confirm"=>"Are you sure you want to $msg this account?",
                            "class"=>"btn btn-danger"
                        ]);
                    }
                ],
            ],
                
        ],
    ]);
        ?>
    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Back to Dashboard'), ['../site/login'], ['class' => 'btn btn-success',]) ?>
    </p>
</div>
