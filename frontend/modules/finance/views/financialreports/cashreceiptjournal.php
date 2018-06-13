<?php


//var_dump($stringTable);
//echo $values;

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 06 7, 18 , 2:51:15 PM * 
 * Module: cashreceiptjournal * 
 */

/**
 * Description of cashreceiptjournal
 *
 * @author mariano
 */
?>


 
 
<h1>Cash Receipt Journal</h1>


<style type="text/css">
    table, th, td {
        border: 1px solid black;
        text-align: center;
       
    }
</style>

<?php



?>
<button onclick="exportTableToExcel('dvData')">Export Table Data To Excel File</button>


<div style="overflow: auto;height: 300px">

    <div id="dvData">
    
     <?php
    echo $stringTable
    ?>
    </div>
   
    

</div>

<br><br>

<script>  
 
       

 function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}


 </script>  






