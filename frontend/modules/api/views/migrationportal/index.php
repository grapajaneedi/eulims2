<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\progress;
/* @var $this yii\web\View */
/* @var $searchModel common\models\api\MigrationportalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Migrationportals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migrationportal-index">

    <h1>Yii 1.0 to 2.0 Migration</h1>

    <h3>customer</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
    <h3>request</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
    <h3>sample</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
    <h3>analysis</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
    <h3>check</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
    <h3>receipt</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
    <h3>deposit</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
    <h3>payment Item</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
    <h3>orderofpayment</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
    <h3>collection</h3>
    <div>
        <?php 
        echo Html::a('Fetch',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
         <?php 
        echo Html::a('Process',array('syncrequest','start'=>0),['class'=>'btn btn-primary btn-small']);
        ?>
    </div>
     <br>
    <?php    // stacked bars
        echo Progress::widget([
            'bars' => [
                ['percent' => 70,'label' => 'Processed', 'options' => ['class' => 'progress-success active']],
                ['percent' => 30, 'label' => 'Pending', 'options' => ['class' => 'progress-warning']],
            ]
        ]);
    ?>
</div>

<?php 
$this->registerCssFile("/css/modcss/migrationportal.css", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'css-search-bar');
?>