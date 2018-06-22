
<!-- <barcode code="04210000526" type="UPCE" /> -->


<?php
use common\models\lab\Analysis;
use common\models\lab\AnalysisSearch;

foreach ($samplesquery as $sample) {
             $analysisquery = Analysis::find()->where(['sample_id' => $sample['sample_id']])->all();
                    foreach ($analysisquery as $analysis){
                        echo $sample['samplename']."<br>";
                        echo $analysis['testname']."<br>";
                    }
              
            }
    
?>


