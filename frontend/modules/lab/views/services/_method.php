<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Services;
use common\models\lab\Lab;
use common\models\lab\Testname;
use common\models\lab\Methodreference;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;

$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');
$lablist= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');
$methodlist= ArrayHelper::map(Methodreference::find()->all(),'method_reference_id','method');
$testnamelist= ArrayHelper::map(Testname::find()->all(),'testname_id','testName');

$this->title = 'Add/ Remove Services';

$js=<<<SCRIPT
    function offerservices(mid){
                $.post('/lab/services/offer', {
                   id: mid,
                   labid: $('#labid').val(),
                   sampletypeid: $('#sampletypeid').val(),
                   methodreferenceid: $('#methodreferenceid').val(),
                }, function(result){
                    $("#testname-grid").yiiGridView("applyFilter");
                
                });
        }

        function unofferservices(mid){
                            $.post('/lab/services/unoffer', {
                               id: mid,
                               labid: $('#labid').val(),
                               sampletypeid: $('#sampletypeid').val(),
                               methodreferenceid: $('#methodreferenceid').val(),
                            }, function(result){
                                $("#testname-grid").yiiGridView("applyFilter");    
                            });
                    }
SCRIPT;
$this->registerJs($js);

?>

<?= Html::textInput('methodreferenceid', $methodreferenceid, ['class' => 'form-control', 'type'=>'hidden', 'id'=>'methodreferenceid'], ['readonly' => true]) ?>
<?= Html::textInput('labid', $labid, ['class' => 'form-control', 'type'=>'hidden', 'id'=>'labid'], ['readonly' => true]) ?>
<?= Html::textInput('sampletypeid', $sampletypeid, ['class' => 'form-control', 'type'=>'hidden', 'id'=>'sampletypeid'], ['readonly' => true]) ?>
  
<?php
 $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
 $servicesquery= Services::find()->Where(['rstl_id'=>$GLOBALS['rstl_id']])->all();

 $servicecount = count($servicesquery);
?>

    <?= GridView::widget([
        'dataProvider' => $testnameDataProvider,
        'pjax' => true,    
        'id'=>'testname-grid',
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'rowOptions' => function($model){

            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
            $servicesquery= Services::find()->where(['method_reference_id' => $model->method_reference_id])->andWhere(['rstl_id'=>  $GLOBALS['rstl_id']])->one();

            if ($servicesquery){
                return ['class'=>'success'];
            }else{
               return ['class'=>'danger'];
            }      
        },
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=>'<span class="btn btn-success legend-font" style="float:left" "id"="servicescount"><span class= "glyphicon glyphicon-upload"></span>SYNC '.$servicecount.'</span>',
               'after'=>false,
            ],
        'columns' => [
            [
                'header'=>'Offered',
                'hAlign'=>'center',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 5%;word-wrap: break-word;white-space:pre-line;'],
                'value'=>function($model){
                    $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                    $servicesquery= Services::find()->where(['method_reference_id' => $model->method_reference_id])->andWhere(['rstl_id'=>  $GLOBALS['rstl_id']])->one();
                    if ($servicesquery){
                       return "<span class='btn btn-success' id='offer' onclick='unofferservices(".$model->method_reference_id.")'>UNOFFER</span>";
                    }else{
                        return "<span class='btn btn-danger' id='offer' onclick='offerservices(".$model->method_reference_id.")'>OFFER</span>";
                    }
                },
                'enableSorting' => false,
            ],
            [
                'attribute' => 'method',
                'label' => 'Method',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 30%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($model) {
                     if($model->method){
                      return $model->method;
                    }else{
                        return "";
                 }    
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $methodlist,
                'format' => 'raw',
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
               ],
            ],
            'reference',
            [
                'attribute' => 'fee',
                'hAlign'=>'center',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 5%;word-wrap: break-word;white-space:pre-line;'],     
            ],
        ],
    ]); ?>


  