<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

//<div class="col-md-4"><a href="/finance/financialreports/collectionsummary/"><img class="img-responsive center-block" src="/images/summaryreportsquare.png" style="height:150px"/></a></div>
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];

$this->params['breadcrumbs'][] ='Financial Reports';
$link2 = '/finance/financialreports/collectionsummary/';
?>
<script type="text/javascript">
$( document ).ready(function() 
{
    
    
    
    $('#el').on('click', function(e) 
        {
        $.ajax({
           type:'POST',
          success: function(data) 
          {
             //  var siteNew = '/finance/financialreports/collectionsummary?year=' + $('#selYear :selected').text();
            //   window.location.href = siteNew;
            if($('#selMonth :selected').val() == '' || $('#selYear :selected').val() == '')
            {
                alert('Year/Month not supplied');
            }
            else
            {
            alert($('#selMonth :selected').val());
                 var siteNew = '/finance/financialreports/collectionsummary?iyear=' + $('#selYear :selected').text() + '?imonth='+ $('#selMonth :selected').val();
                 window.location.href = siteNew;
            }
            
           }
        });
    });
});

function loadUrl(obj)
    {
       if($('#selMonth :selected').val() == '' || $('#selYear :selected').val() == '')
            {
                alert('Year/Month not supplied');
            }
            else
            {
             var siteNew='';
             switch(obj)
             {
                 case 'collection':
                     siteNew = '/finance/financialreports/collectionsummary?year=' + $('#selYear :selected').text() + '&month='+ $('#selMonth :selected').val();
                     break;
                 case 'summary':
                     siteNew = '/finance/financialreports/collectionsummary?iyear=' + $('#selYear :selected').text() + '&imonth='+ $('#selMonth :selected').val();
                     break;
                 case 'receipt':
                     siteNew = '/finance/financialreports/cashreceiptjournal?iyear=' + $('#selYear :selected').text() + '&imonth='+ $('#selMonth :selected').val();
                     break;
                 
             }
             // alert($('#selMonth :selected').val());
               //  var siteNew = '/finance/financialreports/collectionsummary?year=' + $('#selYear :selected').text() + '?month='+ $('#selYear :selected').val();
                 window.location.href = siteNew;
            }
    }
    
    </script>
    
 
    
<style type="text/css">

    .imgHover:hover{
        border-radius: 25px;
        box-shadow: 0 0 0 5pt #3c8dbc;
        transition: box-shadow 0.5s ease-in-out;
    }
</style>

<?php
Pjax::begin(['id' => 'pjax',
    'timeout' => 2000,
    'enablePushState' => false]);
?>
<?php
$form = ActiveForm::begin(
                [
                    'id' => 'test'
        ]);
?>

<div class="box box-primary box-solid" style="background:transparent">
    <div class="box-header with-border" style="text-align:center">
        <h2 class="box-title">Financial Reports</h2>

        <!-- /.box-tools -->
    </div>

    <div class="box-body">

        <div class="row">

            <div class="col-md-6">
                    <?php
                    echo $form->field($model, 'intYear')->dropDownList($listYear, [
                        'id' => 'selYear',
                        'prompt' => 'Select Year',
                        'type'=>'post'
                    ]);
                    ?>
            </div>
            
            <div class="col-md-6">
           
                <?php
                    echo $form->field($model, 'intMonth')->dropDownList($listMonth, [
                        'id' => 'selMonth',
                        'prompt' => 'Select Month',
                        'type'=>'post'
                    ]);
                    ?>
            </div>
        </div>
        
        <div class="row">
           
            <div class="col-md-4"><a href="#" id="el"><img class="img-responsive center-block" src="/images/collectionreportsquare.png" style="height:150px"/></a></div>
            <div class="col-md-4"><a href="#" onclick="loadUrl('summary')"><img class="imgHover img-responsive center-block" src="/images/summaryreportsquare.png" style="height:150px"/></a></div>
            <div class="col-md-4"><a href="#" onclick="loadUrl('receipt')"><img class="imgHover img-responsive center-block" src="/images/cashreceiptsquare.png" style="height:150px"/></a></div>
        </div>




    </div>




</div>


<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>






