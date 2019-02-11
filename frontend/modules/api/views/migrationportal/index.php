<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\progress;
use common\models\lab\CustomerMigration;
use common\models\api\CustomerMigrationportal;


/* @var $this yii\web\View */
/* @var $searchModel common\models\api\MigrationportalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Migrationportals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migrationportal-index">
    
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
             <h4><i class="icon fa fa-check"></i>Saved!</h4>
             <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
             <h4><i class="icon fa fa-warning"></i>Note!</h4>
             <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <h1>Yii 1.0 to 2.0 Migration [Ulimsportal Only]</h1>
    <?php
    foreach ($fetchlings as $fetch) {
        echo "<div>";
        echo "<h3>TBL_".$fetch->table_name."</h3>";

        if($fetch->table_name=="customer"){

            $count_m = CustomerMigration::find()->count();
            $count_mp = CustomerMigrationportal::find()->count();

            echo Html::a('Fetch',array('fetch_customer','start'=>$fetch->record_id),['class'=>'btn btn-primary btn-small']);
            echo "<br>";
            echo "$count_mp  /$count_m records fetch from migration table";
            echo "<br>";

            //know the percentage
            $perc_fetch=0;

            if($count_m!=0){
                $perc_fetch = ($fetch->record_id/$count_m)*100;
                
            }
            $perc_fetch = number_format((float)$perc_fetch, 2, '.', '');
            echo Progress::widget([
                'percent' => $perc_fetch,
                'label' => $perc_fetch.'% Fetch',
                'options' => ['class' => 'progress-success active progress-striped']
            ]);

            //**********************
            
            echo Html::a('Run Script',array('script_customer','start'=>$fetch->record_idscript),['class'=>'btn btn-primary btn-small']);
            echo "<br>";
            echo "$fetch->record_idscript /$count_mp records process";
            echo "<br>";
            //know the percentage
            $perc_fetch_mp=0;
            if($count_mp!=0){
                $perc_fetch_mp = ($fetch->record_idscript/$count_mp)*100;
            }
                 $perc_fetch_mp = number_format((float)$perc_fetch_mp, 2, '.', '');
             echo Progress::widget([
                'percent' => $perc_fetch_mp,
                'label' => $perc_fetch_mp.'% Processed',
                'options' => ['class' => 'progress-success  active progress-striped']
            ]);



        }
        echo "</div>";
    }


    ?>
</div>

<?php 
$this->registerCssFile("/css/modcss/migrationportal.css", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'css-search-bar');
?>