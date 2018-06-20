<?php
/* @var $this yii\web\View */

$this->title = 'Billing';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">

.imgHover:hover{
    border-radius: 25px;
    box-shadow: 0 0 0 5pt #3c8dbc;
    transition: box-shadow 0.5s ease-in-out;
}
</style>

<div class="box box-primary box-solid" style="background:transparent">
    <div class="box-header with-border">
              <h2 class="box-title">Billing Dashboard</h2>

              <!-- /.box-tools -->
    </div>

    <div class="box-body">
   
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12" style="text-align:center"><a href="#"><img class="imgHover img-responsive center-block" src="/images/clientssquare.png" style="height:150px"/></a></div>
        <div class="col-md-3 col-sm-6 col-xs-12" style="text-align:center"><a href="#"><img class="imgHover img-responsive center-block" src="/images/invoicesquare.png" style="height:150px"/></a></div>
        <div class="col-md-3 col-sm-6 col-xs-12" style="text-align:center"><a href="#"><img class="imgHover img-responsive center-block" src="/images/reportsquare.png" style="height:150px"/></a></div>
        <div class="col-md-3 col-sm-6 col-xs-12" style="text-align:center"><a href="#"><img class="imgHover img-responsive center-block" src="/images/agingsquare.png" style="height:150px"/></a></div>
        <div class="col-md-3 col-sm-6 col-xs-12" style="text-align:center"><a href="/finance/billing/manager"><img class="imgHover img-responsive center-block" src="/images/billingmanagersquare.png" style="height:150px"/></a></div>
       
    </div>
   

    </div>
    
</div>