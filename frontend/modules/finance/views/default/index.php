<?php

/* @var $this yii\web\View */

$this->title = 'Finance';
$this->params['breadcrumbs'][] = $this->title;

?>

<style type="text/css">

.imgHover:hover{
    border-radius: 15px;
    box-shadow: 0 0 0 4pt #3c8dbc;
    transition: box-shadow 0.5s ease-in-out;
}
</style>

<div class="Lab-default-index">
    <div class="body-content">
        <div class="box box-primary color-palette-box" style="padding:0px">
        <div class="box-header" style="background-color: #3c8dbc;color:#ffffff">
          <h3 class="box-title"><i class="fa fa-tag"></i>Finance</h3>
          <div class="box-tools pull-right" >
                <button type="button" style="color:#ffffff" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
        </div>      
        <div class="box-body">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                  <a href="/settings" title="Customer Wallet"><img class="imgHover" src="/images/customerwalletsquare.png" style="height:120px;width: 120px" ></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
            
             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/gii" title="Order of Payment"><img class="imgHover" src="/images/ordersquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                   <a href="/debug" title="Accounting Code"><img class="imgHover" src="/images/accountingcodesquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
           
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/module/manager" title="Financial Reports"><img class="imgHover" src="/images/financialsquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <!-- /.col -->
            
            <!-- /.col -->  
          </div>
        </div>
        <!-- /.box-body -->
        </div>
        
        <div class="box box-primary color-palette-box" style="padding:0px">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i>Cashier</h3>
          <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
        </div>      
        <div class="box-body">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
             
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                  <a href="/settings" title="Receipt"><img class="imgHover" src="/images/receiptsquare.png" style="height:120px;width: 120px" ></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
             
             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/gii" title="Order of Payment"><img class="imgHover" src="/images/ordersquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
             
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                   <a href="/debug" title="Deposit"><img class="imgHover" src="/images/depositsquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
             

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/module/manager" title="Reports"><img class="imgHover" src="/images/reportsquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <!-- /.col -->
            
            <!-- /.col -->  
          </div>
        </div>
        <!-- /.box-body -->
        </div>
        
        <div class="box box-primary color-palette-box" style="padding:0px">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i>Accounting</h3>
          <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
        </div>      
        <div class="box-body">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                  <a href="/settings" title="Order of Payment"><img class="imgHover" src="/images/ordersquare.png" style="height:120px;width: 120px" ></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-12">
           
             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/gii" title="Order of Payment (Laboratory)"><img class="imgHover" src="/images/orderlabsquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            <!-- /.col -->
            
            
           
            
            <!-- /.col -->
            
            <!-- /.col -->  
          </div>
        </div>
        <!-- /.box-body -->
        </div>
        
        
        <div class="box box-primary color-palette-box" style="padding:0px">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i>Billing</h3>
          <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
        </div>      
        <div class="box-body">
          <div class="row">
            <div class="col-md-2 col-sm-6 col-xs-12 col-md-offset-1">
             
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                  <a href="/settings" title="Clients"><img class="imgHover" src="/images/clientssquare.png" style="height:120px;width: 120px" ></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-2 col-sm-6 col-xs-12">
            

             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/gii" title="Invoice"><img class="imgHover"  src="/images/invoicesquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-2 col-sm-6 col-xs-12">
             

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                   <a href="/debug" title="Reports"><img class="imgHover" src="/images/reportsquare.png" style="height:120px;width:120px"></a>
              </div>
            </div>
            
            <div class="col-md-2 col-sm-6 col-xs-12">
             

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/module/manager" title="Aging of Accounts"><img class="imgHover" src="/images/agingsquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <div class="col-md-2 col-sm-6 col-xs-12">
           

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/module/manager" title="Billing Manager"><img class="imgHover" src="/images/billingmanagersquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <!-- /.col -->
            
            <!-- /.col -->  
          </div>
        </div>
        <!-- /.box-body -->
        </div>
        
        
    </div>
</div>
