<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\lab\Customer */
$this->title = $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'customer_id',
            'rstl_id',
            'customer_code',
            'customer_name',
            'head',
            'tel',
            'fax',
            'email:email',
            'address',
            'latitude',
            'longitude',
        ],
    ]) ?>

</div>

<?php if(Yii::$app->request->isAjax){ ?>
    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
<?php } ?>