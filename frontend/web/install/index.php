<?php

/* 
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 10 23, 18 , 2:03:16 PM * 
 * Module: index * 
 */
?>


<link rel="stylesheet" href="http://ulimsportal.onelab.ph/assets/386a64a4/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
    /* latin-ext */
    @font-face {
        font-family: 'Audiowide';
        font-style: normal;
        font-weight: 400;
        src: local('Audiowide Regular'), local('Audiowide-Regular'), url('/font/audiowide_latin_ext.woff2') format('woff2');

    }
    /* latin */
    @font-face {
        font-family: 'Audiowide';
        font-style: normal;
        font-weight: 400;
        src: local('Audiowide Regular'), local('Audiowide-Regular'), url('/font/audiowide_latin.woff2') format('woff2');

    }

    .newtext {
        font-size: 72px;
        background: -webkit-linear-gradient( #1b4f72  , #3c8dbc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font: normal 52px/1 "Audiowide", Helvetica, sans-serif;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        font-family: 'Audiowide';
        font-size: 60px;
    }
    .img-responsive {
  display: block;
  max-width: 100%;
  height: auto;
 
}

#panelAgency
{
    display: block;
    
}
#panelLab
{
    display: none;
}

#panelGenerate
{
    display: none;
}

#panelInstall
{
    display: none;
}

#panelInstallDost
{
    display: none;
}

 .rel {
    position: relative;
    height:300px;
    width: 600px;
}
.read-more {
    position: absolute;
    bottom: 0;
    right: 0;
}
.footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1rem;
 
  text-align: center;
  width:100%
}



</style>
<script type="text/javascript">
    function toggler(divId) {
    switch (divId)
    {
        case 'panelAgency':
           // $('#panelAgency').style.display = 'none';
           //  $('#panelLab').style.display = 'block';
              $('#panelAgency').hide();
             $('#panelLab').show();
             break;
        case 'panelLabBack':
           // $('#panelAgency').style.display = 'none';
           //  $('#panelLab').style.display = 'block';
              $('#panelAgency').show();
             $('#panelLab').hide();
             break;
         case 'panelLabNext':
           // $('#panelAgency').style.display = 'none';
           //  $('#panelLab').style.display = 'block';
              $('#panelLab').hide();
             $('#panelGenerate').show();
             break;
             
         case 'panelGenerateBack':
           // $('#panelAgency').style.display = 'none';
           //  $('#panelLab').style.display = 'block';
              $('#panelLab').show();
             $('#panelGenerate').hide();
             break;
         case 'panelGenerateNext':
           // $('#panelAgency').style.display = 'none';
           //  $('#panelLab').style.display = 'block';
              $('#panelGenerate').hide();
             $('#panelInstall').show();
             break;
             
          case 'panelInstallBack':
           // $('#panelAgency').style.display = 'none';
           //  $('#panelLab').style.display = 'block';
              $('#panelGenerate').show();
             $('#panelInstall').hide();
             break;
         case 'panelInstallNext':
           // $('#panelAgency').style.display = 'none';
           //  $('#panelLab').style.display = 'block';
              $('#panelInstall').hide();
             $('#panelInstallDost').show();
             break;
             
             
           case 'panelInstallDostBack':
           // $('#panelAgency').style.display = 'none';
           //  $('#panelLab').style.display = 'block';
              $('#panelInstall').show();
             $('#panelInstallDost').hide();
             break;
             
         case 'panelInstallDostNext':
           // $('#panelAgency').style.display = 'none';
           //  $('#panelLab').style.display = 'block';
              $('#panelGenerate').hide();
             $('#panelInstall').show();
             break;
            
            
            
    }
    
}
    </script>
<br>
<h1 style="font-family: 'Audiowide';text-align: center;color: #3c8dbc">eULIMS Initial Configurations</h1>
<div style="margin:5%;background: linear-gradient(110deg,  #b1d1e4 50%,#3c8dbc 50%);height: 70%"  >
    <div class="d-flex align-items-center" >



        <div>

            <div class="row">

                <div class="col-sm-7">
                    <div>
                        
                        <img src="/images/onelablogonew.png" style="width: 70%;border-radius: 15px 15px;margin: 0 auto;margin-top: 100px" class="img-responsive center-block">
                        <h1 class="newtext" style="text-align: center">
                            e.U.L.I.M.S
                        </h1>
                        <p style="font-family: 'Audiowide';font-size:17px;color:#1b4f72;text-align: center">
                            Enhanced Unified Laboratory Information Management System
                        </p>

                        <p style="font-family: 'Audiowide';font-size:18px;color:#1b4f72;text-align: center">
                            Department of Science and Technology
                        </p>


                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="login-box" >
                        <div class="login-logo">

                        </div>
                        <!-- /.login-logo -->
                        <div class="row" style="position:relative;border-radius: 5px;border: 1px solid #b1d1e4;margin:50px 30px 10px 0px;height:80%;">
                           
                            <div style="margin: 10px" id="panelAgency"> 
                                <h3 for="exampleInputEmail1" style="text-align: center">RSTL Details</h3><br>
                                <div class="form-group">
                                <label for="exampleInputEmail1">Agency / RSTL :</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Agency/RSTL">
                              <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                
                                 <div class="form-group">
                                <label for="exampleInputEmail1">Address :</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Address">
                              <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                
                                 <div class="form-group">
                                <label for="exampleInputEmail1">Agency Type :</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Agency Type">
                              <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="footer">
                                 <button id="btnNextAgency" onclick="toggler('panelAgency')" type="submit" class="btn btn-primary pull-right">Next</button>
                                </div>
                            </div>
                            
                              <div  style="margin: 10px" id="panelLab"> 
                                  <h3 for="exampleInputEmail1" style="text-align: center">Active Laboratories</h3><br>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Microbiology</label>
                                </div>
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Chemical</label>
                                </div>
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Meteorology</label>
                                </div>
                                 
                                
                                <div class="footer">
                                    <button id="btnBackLab" onclick="toggler('panelLabBack')" type="submit" class="btn btn-primary pull-left">Back</button>
                                <button id="btnNextLab" onclick="toggler('panelLabNext')" type="submit" class="btn btn-primary pull-right">Next</button>
                                </div>
                                </div>
                            
                            
                               <div style="margin: 10px" id="panelGenerate"> 
                                  <h3 for="exampleInputEmail1" style="text-align: center">Generate Database</h3><br>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Microbiology</label>
                                </div>
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Chemical</label>
                                </div>
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Meteorology</label>
                                </div>
                                 <div class="footer">
                                <button id="btnBacGenerate" onclick="toggler('panelGenerateBack')" type="submit" class="btn btn-primary pull-left">Back</button>
                                <button id="btnNextGenerate" onclick="toggler('panelGenerateNext')"  type="submit" class="btn btn-primary pull-right">Next</button>
                                 </div>
                            </div>
                            
                             <div style="margin: 10px" id="panelInstall"> 
                                  <h3 for="exampleInputEmail1" style="text-align: center">Install Database(Non - DOST)</h3><br>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Microbiology</label>
                                </div>
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Chemical</label>
                                </div>
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Meteorology</label>
                                </div>
                                 <div class="footer">
                                <button id="btnBackInstall" onclick="toggler('panelInstallBack')" type="submit" class="btn btn-primary pull-left">Back</button>
                                <button id="btnNextInstall" onclick="toggler('panelInstallNext')"  type="submit" class="btn btn-primary pull-right">Skip</button>
                                 </div>
                            </div>
                            
                            <div style="margin: 10px" id="panelInstallDost"> 
                                  <h3 for="exampleInputEmail1" style="text-align: center">Install Database(DOST)</h3><br>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Microbiology</label>
                                </div>
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Chemical</label>
                                </div>
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Meteorology</label>
                                </div>
                                 <div class="footer">
                                <button id="btnBackInstallDost" onclick="toggler('panelInstallDostBack')" type="submit" class="btn btn-primary pull-left">Back</button>
                                <button id="btnNextInstall" onclick="toggler('panelInstallDostNextr')"  type="submit" class="btn btn-primary pull-right">Finish</button>
                                 </div>
                            </div>
                            
                            
                      

                            
                           
                            

                           
                         
                            
                           
                        </div>
                        <!-- /.login-box-body -->
                    </div>
                </div>
            </div> 

        </div>
    </div>
</div>
