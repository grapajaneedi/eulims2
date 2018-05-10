<?php

/* @var $this yii\web\View */

$this->title = 'Admin EULIMS';
?>
<link href="/css/site.css" rel="stylesheet">
<div class="site-index">

  
    <div class="body-content">

        <div class="box box-default color-palette-box" style="padding:0px">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> System Settings</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">System Maintenance</h4>
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                  <a href="/settings" title="System Maintenance"><img src="/images/system.png" style="height:40%;width: 40%" ></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Gii</h4>

             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/gii" title="Yii Code Generator"><img src="/images/yii2.png" style="height:35%;width: 35%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Debug</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                   <a href="/debug" title="Debug"><img src="/images/system.png" style="height:40%;width: 40%"></a>
              </div>
            </div>
            
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Package Manager</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/package/manager" title="Package Manager"><img src="/images/package.png" style="height:35%;width: 35%"></a>
              </div>
            </div>
            
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Package List</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/package" title="Package List"><img src="/images/list.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Package Details</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/package/details" title="Package Details"><img src="/images/details.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <!-- /.col -->
            
           
          </div>
          <!-- /.row -->
          
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
        
        <div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> Role Based Access Control (RBAC) Settings</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Users</h4>
              <div  style="padding-top: 1px;padding-bottom: 5px;display:block;text-align: center">
                 <a href="/admin/user" title="Debug"><img src="/images/users.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Assignment</h4>

             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                <a href="/admin" title="Debug"> <img src="/images/assignment.png" style="height:25%;width: 25%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Route</h4>

              <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                <a href="/admin/route" title="Debug"> <img src="/images/route.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Roles</h4>

              <div  style="padding-top: 1px;padding-bottom: 5px;display:block;text-align: center">
                <a href="/admin/role" title="Debug"> <img src="/images/roles.png" style="height:40%;width: 40%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Permissions</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/admin/permission" title="Debug"><img src="/images/permission.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Menus</h4>

             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/admin/menu" title="Debug"> <img src="/images/menus.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
           
          </div>
          <!-- /.row -->
          <div class="row">
            
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Rules</h4>

              <div  style="padding-top: 1px;padding-bottom: 20px;display:block;text-align: center">
                 <a href="/admin/rule" title="Debug"> <img src="/images/rules.png" style="height:30%;width: 30%"></a>
                 
              </div>
            </div>
            
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">System Maintenance</h4>

              <div  style="padding-top: 1px;padding-bottom: 20px;display:block;text-align: center">
                 <a href="#" onclick="LoadModal('Debug','/debug')" title="Debug"> <img src="/images/rules.png" style="height:30%;width: 30%"></a>
                 
              </div>
            </div>
            <!-- /.col -->
           
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>

    </div>
</div>
