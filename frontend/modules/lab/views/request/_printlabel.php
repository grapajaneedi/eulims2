<!-- <barcode code="20889 CHE-0859" type="C39" /> -->

<style>
body {
	font-family: \'DejaVu Sans Condensed\';
}
@page {
	margin-top: 0cm;
	margin-bottom: 0cm;
	margin-left: 0cm;
	margin-right: 0cm;
	margin-header: 0mm;
	margin-footer: 0mm;
	background-color:#ffffff;
}
</style>


<?php




    foreach ($samplesquery as $sample) {
       
            //  $analysisquery = Analysis::find()->where(['sample_id' => $sample['sample_id']])->all();
              echo $sample['samplename']."<br>";
            // echo $sample['sample_code']."<br>";
              //     foreach ($analysisquery as $analysis){
                  //    var_dump($analysisquery);
           //            echo "&nbsp;&nbsp;&nbsp;&nbsp;".$analysis['testname']."<br>";
               //    }
                  // echo "<div className='page-break'></div>";  
               $mpdf->AddPage('','','','','',0,0, 0, 0);
            }       
?>



