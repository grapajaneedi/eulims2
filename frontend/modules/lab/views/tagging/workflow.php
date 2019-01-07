
<?php
 // use kartik\grid\GridView;
 use yii\grid\GridView;
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        [
            'attribute'=>'procedure_name',
            'enableSorting' => false,
        ],
          [
                    'header'=>'Analyst',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value'=> function ($model){
                        return " ";
                        // if ($model->tagging){
                        //     $profile= Profile::find()->where(['user_id'=> $model->tagging->user_id])->one();
                        //     return $profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
                        // }else{
                        //     return "";
                        // } 
                    },
                   // 'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                   
                ], 
                [
                    'header'=>'Status',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value'=> function ($model){
                        return " ";
                        // if ($model->tagging){
                        //     $profile= Profile::find()->where(['user_id'=> $model->tagging->user_id])->one();
                        //     return $profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
                        // }else{
                        //     return "";
                        // } 
                    },
                   // 'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                   
                ],    
                [
                    'header'=>'Remarks',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value'=> function ($model){
                        return " ";
                        // if ($model->tagging){
                        //     $profile= Profile::find()->where(['user_id'=> $model->tagging->user_id])->one();
                        //     return $profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
                        // }else{
                        //     return "";
                        // } 
                    },
                  //  'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                   
                ],      
    ];
    echo GridView::widget([
        'id' => 'result-grid',
        'dataProvider'=> $model,
       //  'panel' => [
        //     //               'type' => GridView::TYPE_PRIMARY,
        //     //                 'heading' => '<span class="glyphicon glyphicon-book"></span>  Analysis' ,
        //     //                 'footer'=>Html::button('<i class="glyphicon glyphicon-tag"></i> Start Analysis', ['disabled'=>false,'value' => Url::to(['tagging/startanalysis','id'=>1]), 'onclick'=>'startanalysis()','title'=>'Start Analysis', 'class' => 'btn btn-success','id' => 'btn_start_analysis'])." ".
        //     //                 Html::button('<i class="glyphicon glyphicon-ok"></i> Completed', ['disabled'=>false,'value' => Url::to(['tagging/completedanalysis','id'=>1]),'title'=>'Completed', 'onclick'=>'completedanalysis()', 'class' => 'btn btn-success','id' => 'btn_complete_analysis']),
         //             ],
        'columns' => $gridColumns,

    ]);

  //  echo "Html::button('<i class='glyphicon glyphicon-tag'></i> Start Analysis', ['disabled'=>false,'value' => Url::to(['tagging/startanalysis','id'=>1]), 'onclick'=>'startanalysis()','title'=>'Start Analysis', 'class' => 'btn btn-success','id' => 'btn_start_analysis'])";
?>

