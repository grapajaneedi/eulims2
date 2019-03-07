<?php

use common\models\lab\Sample;
use common\models\lab\Analysis;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

use common\models\lab\Tagging;
use common\models\lab\Tagginganalysis;
use common\models\lab\Workflow;
use common\models\lab\Testnamemethod;
use common\models\lab\Methodreference;
use common\models\lab\Request;
use common\models\lab\Procedure;
use common\models\TaggingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use common\models\system\Profile;

?>

<span style="display:inline-block;">

<?php echo "<font color='#666666'>Request Reference #:</font><br \><b style='font-size:1.25em;'>". $request->request_ref_num."</b>";?>

</span>

<?php

echo "<span class='payment alert-warning' style='float:right; min-width:80px; min-height:30px; line-height:30px;text-align:center;display:inline-block;font-weight:bold;'>Pending</span><br><br>";

//  if (($countdata==0)){
	
// }else if (($countdata==$request->completed) || ($countdata<$request->completed)){
// 	echo "<span class='payment alert-success' style='float:right; min-width:80px; min-height:30px; line-height:30px;text-align:center;display:inline-block;font-weight:bold;'>Completed</span>";
// }else if (($request->completed==0)){
// 	echo "<span class='payment alert-warning' style='float:right; min-width:80px; min-height:30px; line-height:30px;text-align:center;display:inline-block;font-weight:bold;'>Pending</span>";
// }
// else if (($request->completed<$coundata) || ($request->completed!=0)){
// 	echo "<span class='payment alert-info' style='float:right; min-width:80px; min-height:30px; line-height:30px;text-align:center;display:inline-block;font-weight:bold;'>Ongoing</span>";
// }
?>

<?php
//  GridView::widget([
//     'dataProvider' => $sampledataprovider,
//     'pjax'=>true,
//     'headerRowOptions' => ['class' => 'kartik-sheet-style'],
//     'filterRowOptions' => ['class' => 'kartik-sheet-style'],
//     'bordered' => true,
//     'id'=>'sample-grid',
//     'striped' => true,
//     'condensed' => true,
//     'responsive'=>false,
//     'containerOptions'=>[
//         'style'=>'overflow:auto; height:320px',
//     ],
//     'pjaxSettings' => [
//         'options' => [
//             'enablePushState' => false,
//         ]
//     ],
//     'floatHeaderOptions' => ['scrollingTop' => true],
//     'columns' => [
//      [
//         'header'=>'Sample Code',
//         'hAlign'=>'left',
//         'format' => 'raw',
//         'enableSorting' => false,
//         'value'=> function ($model){ 
//             $sample = Sample::find()->where(['sample_id' => $model->sample_id])->one();
//             return $sample->sample_code;
//         },
//         'contentOptions' => ['style' => 'width:15%; white-space: normal;'],                   
//     ],
//     [
//         'header'=>'Sample Name',
//         'hAlign'=>'left',
//         'format' => 'raw',
//         'enableSorting' => false,
//         'value'=> function ($model){
//             $sample = Sample::find()->where(['sample_id' => $model->sample_id])->one();
//             return $sample->samplename;
//         },
//         'contentOptions' => ['style' => 'width:15%; white-space: normal;'],                   
//     ],
//     [
//         'header'=>'Progress',
//         'hAlign'=>'left',
//         'format' => 'raw',
//         'enableSorting' => false,
//         'value'=> function ($model){
//           //$workflow= Workflow::find()->where(['workflow_id'=> $model->analysis_id])->one(); 
//          return "";
//         },
//         'contentOptions' => ['style' => 'width:15%; white-space: normal;'],                   
//     ],
//     [
//         'header'=>'Status',
//         'hAlign'=>'left',
//         'format' => 'raw',
//         'enableSorting' => false,
//         'value'=> function ($model){
//           //$workflow= Workflow::find()->where(['workflow_id'=> $model->analysis_id])->one(); 
//          return "";
//         },
//         'contentOptions' => ['style' => 'width:15%; white-space: normal;'],                   
//     ],
         
// ],
// ]); 
?>
<div class="testnamemethod-index">
<?php
               $gridColumns = [
              
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'width' => '1%',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($model, $key, $index, $column) {
         
                        $analysisQuery = Analysis::find()->where(['sample_id' => $model->sample_id]);
                        $analysis_id = $model->sample_id;
                        $id = $model->sample_id;
                        $model = new Tagging();

                        
                                    $analysisdataprovider = new ActiveDataProvider([
                                            'query' =>  $analysisQuery,
                                            'pagination' => [
                                                'pageSize' => false,
                                                    ],                 
                                    ]);
                                        
                                    if(Yii::$app->request->isAjax){
                                        return $this->renderAjax('_statusanalysis', [
                                            'model'=>$model,
                                            'analysisQuery'=>$analysisQuery,
                                            'analysisdataprovider'=> $analysisdataprovider,
                                            'analysis_id'=>$analysis_id,
                                            'id'=>$id,
                                            ]);
                     }
                    },
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'expandOneOnly' => true
                ],
                [
                            'header'=>'Sample Code',
                            'hAlign'=>'left',
                            'format' => 'raw',
                            'enableSorting' => false,
                            'value'=> function ($model){ 
                                $sample = Sample::find()->where(['sample_id' => $model->sample_id])->one();
                                return $sample->sample_code;
                            },
                            'contentOptions' => ['style' => 'width:15%; white-space: normal;'],                   
                        ],
                        [
                            'header'=>'Sample Name',
                            'hAlign'=>'left',
                            'format' => 'raw',
                            'enableSorting' => false,
                            'value'=> function ($model){
                                $sample = Sample::find()->where(['sample_id' => $model->sample_id])->one();
                                return $sample->samplename;
                            },
                            'contentOptions' => ['style' => 'width:15%; white-space: normal;'],                   
                        ],
                        [
                            'header'=>'Progress',
                            'hAlign'=>'center',
                            'format' => 'raw',
                            'enableSorting' => false,
                            'value'=> function ($model){
                             
                            $samples = Sample::find()->where(['sample_id' =>$model->sample_id])->one();
                            $count = Sample::find()->where(['request_id' =>$model->request_id])->count();
                             
                            if ($count==0){
                                return $samples->completed.'/'.$count;
                            }else{
                                $percent = $samples->completed / $count * 100;
                                $formattedNum = number_format($percent);
                                
                                return "<b>".$samples->completed.'/'.$count." = ".$formattedNum."%</b>";  
                            }

                            },
                            'contentOptions' => ['style' => 'width:15%; white-space: normal;'],                   
                        ],
                        [
                            'header'=>'Status',
                            'hAlign'=>'left',
                            'format' => 'raw',
                            'enableSorting' => false,
                            'value'=> function ($model){
                              //$workflow= Workflow::find()->where(['workflow_id'=> $model->analysis_id])->one(); 
                             return "";
                            },
                            'contentOptions' => ['style' => 'width:15%; white-space: normal;'],                   
                        ],
            ];   
            echo GridView::widget([
                'id'=>'testname-grid',
                'dataProvider' => $sampledataprovider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
               'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'panel' => [
                    //'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i> Workflow Management</h3>',
                    'type'=>'primary',
                ],
                'columns' => $gridColumns,
            
            ]);
        ?>

</div>