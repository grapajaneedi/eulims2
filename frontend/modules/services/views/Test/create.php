<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\services\Test */

$this->title = 'Create Test';
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-create">

  
    
    <?= 
    //  $testcategory = $this->listTestcategory(1);
    //  $sampletype = [];
    $this->render('_form', [
        'model' => $model,
        'testcategory'=>$testcategory,
        'sampletype'=>$sampletype,
    ])
    
    
    ?>
 <?php

class TestController extends Controller
{
   protected function listTestcategory($labId)
   {
       $testcategory = ArrayHelper::map(Testcategory::find()->andWhere(['lab_id'=>$labId])->all(), 'testcategory_id', 
          function($testcategory, $defaultValue) {
              return $testcategory->category_name;
       });

       /*$testcategory = ArrayHelper::map(Testcategory::find()
           ->where(['lab_id' => $labId])
           ->all(), 'testcategory_id', 'category_name');*/

       return $testcategory;
   }
}
 ?>
</div>
