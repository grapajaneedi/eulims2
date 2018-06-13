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
     $arrayUACS =['2-03-01-020','1-01-01-010','1-01-02-020','1-01-04-010','4-03-01-010','1-01-01-010(TF)','','',];
     
     $mysqli = new mysqli('localhost', 'eulims', 'eulims', 'eulims_finance');
     
     $sql = 'Call eulims_finance.spGetCollectionSummary()';
        $res = $mysqli->query($sql);

        $values = $res->fetch_all(MYSQLI_ASSOC);
        $columns = array();

        if(!empty($values)){
            $columns = array_keys($values[0]);
        }
        $tableWidth = ((count($columns)-1) * 100) + 500;
        $rowcount=mysqli_num_rows($res);
 
        $stringTable = '<table id="tblCashreceipt" style="width:' .$tableWidth . 'px;"> <tr>
        <td style="width:397px">Cell</td>
        <td style="width:97px">Debit</td>
        <td style="width:' .((count($columns)-1) * 100) . 'px">Credit</td>
        <td style="width:297px">Sundry</td></tr></table>';

        $stringTable = $stringTable . '<table style="width:' .$tableWidth . 'px;">
        <tr>
            <td style="width:100px">Date</td>
            <td style="width:100px">Reference</td>
            <td style="width:100px">Jev No</td>
            <td style="width:100px">Payor</td>
            <td style="width:100px">1-01-014-010</td>';
        
           
            for ($i =1;$i<count($columns);$i++) 
                {
                $stringTable = $stringTable .' <td style="width:100px">' . $columns[$i] . '</td>';
            }
            $stringTable = $stringTable . '<td style="width:100px">UACS Code</td><td style="width:100px">Debit</td><td style="width:100px">Credit</td></tr>';
                       
            $stringTD = '';
            $total = 0;

            for ($i =1;$i<count($columns);$i++) 
            {
                $tmpValue=0;
               
                for($j=0;$j<$rowcount;$j++)
                    {
                    $tmpValue = $tmpValue + $values[$j][$columns[$i]] ;
                    }
                    $total = $total + $tmpValue;
                    $stringTD = $stringTD . '<td style="width:100px">'. $tmpValue . '</td>';
            }

            $stringTable = $stringTable . '<tr><td style="width:100px"></td>
            <td style="width:100px"></td>
            <td style="width:100px"></td>
            <td style="width:100px">Various</td>
            <td style="width:150px">'. $total . '</td>';

            $stringTable = $stringTable . $stringTD;   
            
            $stringTable = $stringTable .'<td style="width:100px"></td><td style="width:100px"></td><td style="width:100px"></td></tr>';
            
            foreach($arrayUACS as $uacs)
            {

            $stringTable = $stringTable . '<tr style="height:20px"><td style="width:100px"></td>
            <td style="width:100px"></td>
            <td style="width:100px"></td>
            <td style="width:100px"></td>
            <td style="width:150px"></td>';
            
                    for ($i =1;$i<count($columns);$i++) 
                    {
                        $stringTable = $stringTable . '<td style="width:100px"></td>';
                    }
                    $stringTable = $stringTable . '<td style="width:150px">' . $uacs . '</td><td style="width:100px"></td><td style="width:100px"></td></tr>';
            }

            $stringTable = $stringTable . '<tr><td style="width:100px"></td>
            <td style="width:100px"></td>
            <td style="width:100px"></td>
            <td style="width:100px">Total</td>
            <td style="width:150px">'. $total . '</td>';

            $stringTable = $stringTable . $stringTD;   
            
            $stringTable = $stringTable .'<td style="width:100px"></td><td style="width:100px"></td><td style="width:100px"></td></tr>';
            
          
            $test=count($columns);

            $stringTable = $stringTable . '</table>';
   
    
     return $this->render('cashreceiptjournal',['dataHeader'=>$dataHeader,'stringTable'=>$stringTable,'values'=>$test]);
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
