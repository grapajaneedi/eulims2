<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Accountingcodemapping */

$this->title = 'Add Accountingcode Mapping';
$this->params['breadcrumbs'][] = ['label' => 'Accountingcodemappings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;




// sql query for calling the procedure
   
?>


<div class="accountingcodemapping-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
        'modelAccountCode' =>  $modelAccountCode,
        'dataProviderAccountCode' => $dataProviderAccountCode,
        'modelCollectionType' =>$modelCollectionType,
        'dataProviderCollectionType' =>$dataProviderCollectionType,
        'modelAccountCollection' => $modelAccountCollection,
        'dataProviderAccountCollection' => $dataProviderAccountCollection
        
    ]) ?>
    
    

</div>




 