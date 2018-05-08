<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\file\FileInput;
use yii\helpers\Url;
use budyaga\cropper\Widget;
use yii\widgets\ActiveForm;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $model common\models\Profile */

//$this->title = $model->firstname;
//$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['/profile']];
//$this->params['breadcrumbs'][] = $this->title;
$path = Yii::getAlias("@webroot")."\uploads\user\photo\\";
/*Modal::begin([
    'header' => '<h3 style="margin-top: 0px;margin-bottom: 0px">'.$model->user->profile->firstname.' '.$model->user->profile->lastname.'</h3><br style="margin-top: 0px;margin-bottom: 0px">'.$model->user->profile->designation,
    'size'   => 'model-big',
    //'toggleButton' => ['label' => 'click me'],
]);
echo Html::img(Yii::$app->urlManagerBackend->baseUrl.'\uploads\user\photo\\'.$model->getImageUrl(), [ 
                    'class' => 'img-thumbnail img-responsive',
                    'alt' => $model->user->username,
                    'width'=>400
                ]) ;
Modal::end();
*/
?>
<div class="profile-view">
    <div class="row">
   <div class="col-md-2">
        <?=
        Html::img(Yii::$app->urlManagerBackend->baseUrl . '\uploads\user\photo\\' . $model->getImageUrl(), [
            'class' => 'img-thumbnail img-responsive',
            'alt' => $model->user->username,
            'width' => 200,
            'data-toggle' => 'modal',
            'data-target' => '#w0'
        ])
        ?>
    </div>
    <div class="col-md-12">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'user_id',
                    'label' => 'Username',
                    'value' => function($model) {
                        return $model->user->username;
                    }
                ],
                'lastname',
                'firstname',
                'designation',
                'middleinitial',
                [
                    'rstl_id' => 'rstl_id',
                    'label' => 'RSTL',
                    'value' => function($model) {
                        return $model->rstl->name;
                    }
                ],
                [
                    'lab_id' => 'lab_id',
                    'label' => 'Laboratory',
                    'value' => function($model) {
                        return $model->lab->labname;
                    }
                ],
                'contact_numbers',
            ],
        ])
        ?>
    </div>
    <div style="position:absolute;right:18px;bottom:10px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
    </div>
</div>
