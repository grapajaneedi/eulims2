<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\Functions;
use yii\bootstrap\Modal;

$func= new Functions();
/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
// $this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyBkbMSbpiE90ee_Jvcrgbb12VRXZ9tlzIc&libraries=places');
$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("/js/customer/customer.js");
?>
<div class="customer-index">

    <p>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create New Customer', ['value'=>'/customer/info/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create New Customer"),'name'=>'Create New Customer']); ?>

         <!-- <?= Html::a('Create New Customer', ['create'], ['class' => 'btn btn-success','target'=>'_']) ?> -->

    </p>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'customer_id',
                // 'rstl_id',
                'customer_code',
                'customer_name',
                // 'head',
                //'tel',
                //'fax',
                //'email:email',
                'address',
                //'latitude',
                //'longitude',
                //'customer_type_id',
                //'business_nature_id',
                //'industrytype_id',
                //'created_at',

                ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 8.7%'],
                'visible'=> Yii::$app->user->isGuest ? false : true,
                'template' => '{view}{update}',
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        $t = '/customer/info/update/?id='.$model->customer_id;
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Update Info of ".$model->customer_name),'name' => Yii::t('app', "Update Info of <font color='#272727'>[<b>".$model->customer_name."</b>]</font>")]);
                        // return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->customer_id], ['class' => 'btn btn-success','target'=>'_']);
                    },
                    'view'=>function ($url, $model) {
                        $t = '/customer/info/view?id='.$model->customer_id;
                        return Html::button('<span class="fa fa-eye"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-primary btn-modal','title' => Yii::t('app', "View Info of ".$model->customer_name),'name' => Yii::t('app', "View Info of  <font color='#272727'>[<b>".$model->customer_name."</b>]</font>")]);
                    },
                    
                ],
            ],
            ],
        ]); ?>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= \Yii::$app->params['googlekey']?>&libraries=places"></script>
<?php
    Modal::begin([
    'options' => [
        'id' => 'gmodal',
        'tabindex' => false, // important for Select2 to work properly
        //'class' => 'modal draggable fade',
    ],
    'header' => '<h4 class="modal-title">New Profile</h4>'
    ]);
    echo "<div>";
    //echo "<div id='modalContent' style='margin-left: 5px; padding-bottom:10px;'><img src='/images/ajax-loader.gif' alt=''/></div>";
   ?>
    <STRONG>Select Location Here</STRONG><br>
    <input id="searchTextField" type="text" size="50"/>
    <div id="output"></div><br /><br />     
    <div id="map" style="width: auto;height: 400px;"></div> 
   <?php
    echo "<div>&nbsp;</div>";
    echo "</div>";
    Modal::end();
    ?>

<?php 

$this->registerJsFile("/js/customer/autocomplete.js");
$this->registerJsFile("/js/customer/google-map-marker.js");

?>
        

<?php
    // This section will allow to popup a notification
    $session = Yii::$app->session;
    if ($session->isActive) {
        $session->open();
        if (isset($session['deletepopup'])) {
            $func->CrudAlert("Deleted Successfully","WARNING");
            unset($session['deletepopup']);
            $session->close();
        }
        if (isset($session['updatepopup'])) {
            $func->CrudAlert("Updated Successfully");
            unset($session['updatepopup']);
            $session->close();
        }
        if (isset($session['savepopup'])) {
            $func->CrudAlert("Saved Successfully","SUCCESS",true);
            unset($session['savepopup']);
            $session->close();
        }
    }
    ?>
</div>


    



