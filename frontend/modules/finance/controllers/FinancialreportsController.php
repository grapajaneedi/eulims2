<?php

namespace frontend\modules\finance\controllers;



use Yii;
use yii\db\Query;
use yii\helpers\Json;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;
use kartik\dynagrid\DynaGrid;

class FinancialreportsController extends \yii\web\Controller
{
    public function actionCollectionsummary()
    {
        $queryA = new yii\db\Query;
        $queryNew =  'Call eulims_finance.spGetCollectionSummary();';
         $columnArray = array();
          $columnArrayNew = array();
          
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM eulims_finance.tbl_collectiontype')->queryScalar();
        $columnHeaders = Yii::$app->db->createCommand('SELECT accountcode FROM eulims_finance.tbl_accountingcode')->queryAll();
        
        $columnArray[] = 'natureofcollection';
        foreach ($columnHeaders as $col)
            {
            $columnArray[]=$col['accountcode'];
           
            }
            
        $dataProviderCollectionSummary = new SqlDataProvider([
            'sql' => $queryNew,
            'totalCount' => $count,
        ]);
        $totalWidth = $count *150;
        $finalWidth = 1500;
        if($totalWidth>$finalWidth)
        {
            $finalWidth = $totalWidth;
        }
        
        $gridOptions='text-align:left;font-size:12px;width:'. $finalWidth .'px';
        
        
        
        return $this->render('collectionsummary',['dataProviderCollectionSummary' => $dataProviderCollectionSummary,
            'columnArray'=>$columnArray,
            'columnHeaders' =>$columnHeaders,
            'columnArrayNew'=>$columnArrayNew,
            'gridOptions'=>$gridOptions,
         
           
            ]);
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTest()
    {
        $columnHeaders =Yii::$app->db->createCommand('SELECT accountcode FROM eulims_finance.tbl_accountingcode')->queryAll();
        
        
        
        echo \yii\helpers\Json::decode(['output'=>$columnHeaders, 'selected'=>'']);
            return;
            
       // return $this->render('index');
    }
    
    

}
