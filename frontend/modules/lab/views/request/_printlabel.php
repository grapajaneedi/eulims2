
<!-- <barcode code="04210000526" type="UPCE" /> -->
<?php

// namespace frontend\modules\lab\controllers;
// use kartik\mpdf\Pdf;
// use common\models\lab\Analysis;
// use common\models\lab\AnalysisSearch;

// echo $request->request_datetime."<br>";
// echo $request->report_due."<br>";
foreach ($samplesquery as $sample) {
            //  $analysisquery = Analysis::find()->where(['sample_id' => $sample['sample_id']])->all();
              echo $sample['samplename']."<br>";
            //  echo $sample['sample_code']."<br>";
              //     foreach ($analysisquery as $analysis){
                  //    var_dump($analysisquery);
           //            echo "&nbsp;&nbsp;&nbsp;&nbsp;".$analysis['testname']."<br>";
               //    }
                   echo "<div className='page-break'></div>";
            }
           
          //  $pdf = new Pdf();

        
            
?>


