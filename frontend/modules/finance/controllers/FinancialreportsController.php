<?php

namespace frontend\modules\finance\controllers;


use mysqli;
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
       // $queryA = new yii\db\Query;
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
    
    public function actionCashreceiptjournal()
    {
     $dataHeader = Yii::$app->db->createCommand('Call eulims_finance.spGetCollectionSummary()');
     $stringTable="<table>";
     
     $mysqli = new mysqli('localhost', 'eulims', 'eulims', 'eulims_finance');
     
     $sql = 'Call eulims_finance.spGetCollectionSummary()';
        $res = $mysqli->query($sql);

        $values = $res->fetch_all(MYSQLI_ASSOC);
        $columns = array();

        if(!empty($values)){
            $columns = array_keys($values[0]);
        }
        
        $stringTable ='<table style="width:1800px;">
        <tr>
            <td style="width:75px">Date</td>
            <td style="width:75px">Reference</td>
            <td style="width:75px">Jev No</td>
            <td style="width:75px">Payor</td>
            <td style="width:100px">1-01-014-010</td>';
        
           
            for ($i =1;$i<count($columns);$i++) 
                {
                $stringTable = $stringTable .' <td style="width:100px">' . $columns[$i] . '</td>';
            }
            $stringTable = $stringTable . '<td style="width:100px">UACS Code</td><td style="width:100px">Debit</td><td style="width:100px">Credit</td></tr></table>';
        
        
   
    
     return $this->render('cashreceiptjournal',['dataHeader'=>$dataHeader,'stringTable'=>$stringTable]);
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
