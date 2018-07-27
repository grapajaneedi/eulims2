<?php

use yii\web\JsExpression;
use yii\helpers\Url;
use edofre\fullcalendar\Fullcalendar;

use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use common\models\system\LoginForm;


/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

?>

<style type="text/css">
    .carousel-indicators {
        bottom:-30px;
    }

    .carousel-indicators li {
        border-color:#999;
        background-color:#ccc;
    }

    .carousel-inner {
        margin-bottom:20px;
    }
    
    .carousel-control.left .glyphicon {
    left: 0;
    margin-left: 0;
    display: none;
}
.carousel-control.right .glyphicon {
    right: 0;
    margin-right: 0;
    display: none;
}


</style>

<?php
//$yrSelect = '2015';


$listLab =  $data['listlab'];  // array("Chemical", "Microbiology", "Metrology", "Rubber", "TestLab", "TestLab2", "TestLab3");
$listLabCode =  $data['listlabcode'];
$listLabCount =  $data['listlabcount']; //array(400, 500, 600, 700, 800, 900, 1000);
$listLabColor =  $data['listlabcolor']; // array("red", "green", "blue", "orange", "aqua", "purple", "orange");
$listLabIcons =  $data['listlabicons']; //array("fa fa-comments-o", "fa fa-thumbs-o-up", "fa fa-bookmark-o", "fa fa-comments-o", "fa fa-bookmark-o", "fa fa-comments-o", "fa fa-bookmark-o");

$labCount = count($listLab);


$tmpValue = $labCount % 4;
$slideCount = ($labCount - $tmpValue) / 4;


if ($tmpValue >= 1) {
    $slideCount++;
}

$listYear =  $data['listyear'];//array("2015","2016","2017");
$listColumn =  $data['listcolumn'];// array("Rank", "Test Name", "No. of Tests");
$dataTop10 =  $data['datatop10'];


?>

<script type="text/javascript">
    

    $('body').on('click', '.option li', function () {
        var i = $(this).parents('.select').attr('id');
        var v = $(this).children().text();
        var o = $(this).attr('id');
        $('#' + i + ' .selected').attr('id', o);
        $('#' + i + ' .selected').text(v);
        $('#selectedOption').val(v);
        
        
    });

    $(function () {
        $('ul.nav li').on('click', function () {
            $(this).parent().find('li.active').removeClass('active');
            $(this).addClass('active');
        });
    });
    
    function showDropYear(obj,graphType) {
      
    var x = document.getElementById("dropYearTwo");
    
    if (obj==1) {
        x.style.display = "block";
    } 
    if (obj==0)
    {
        x.style.display = "none";
    }
    
        
    switch(graphType) {
    case 'firms':
        graphTitle = 'FIRMS ASSISTED';
        yAxisLabel = 'No. of Firms Assisted';
        break;
    case 'income':
        graphTitle = 'INCOME GENERATED';
        yAxisLabel = 'No. of Income Generated';
        break;
    case 'assistance':
        graphTitle = 'VALUE OF ASSISTANCE RENDERED';
        yAxisLabel = 'No. of Value of Assistance Rendered';
        break;
    case 'calibration':
        graphTitle = 'TESTING/CALIBRATION SERVICES RENDERED';
        yAxisLabel = 'No. of Testing/Calibration Services Rendered';
        break;
    case 'customer':
        graphTitle = 'CUSTOMERS SERVED';
        yAxisLabel = 'No. of Customers Served';
        break;
    
} 
    
     $.ajax({
                type: "POST",
                url: "<?php echo Yii::$app->getUrlManager()->createUrl('site/retrievecolumn');?>",
                data: {columnType: graphType},
                success: function (data) {
                     
                     var chartColumn = $('#labColumnChart').highcharts();
                     
                     chartColumn.series[0].setData([]);
                     chartColumn.series[1].setData([]);
                     chartColumn.series[2].setData([]);
                     chartColumn.series[3].setData([]);
                     
                     chartColumn.setTitle({text: graphTitle});
                     chartColumn.yAxis[0].update({
                            title:{
                                text:yAxisLabel
                            }
                        });
                   var dataNew = data;
                   
                   for(i=0; i<chartColumn.series.length; i++)
                        {
                            chartColumn.series[i].update({
                                name: dataNew[i].name,
                                data:dataNew[i].data,
                                color:dataNew[i].color
                            });
                        } 
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                  }
            })
            ;
    
} 

function updateRecord(obj) {
       
        $.ajax({
                type: "POST",
                url: "<?php echo Yii::$app->getUrlManager()->createUrl('site/retrievechart')  ; ?>",
                data: {yearParam: obj},
                success: function (data) {
                 //   alert(data);
                     
                     var chart = $('#yearlyPieChart').highcharts();
                      chart.setTitle({ text: 'Testing/Calibration Services Rendered by Lab - ' + obj});
                     chart.series[0].setData([]);
                     chart.series[0].setData(data);
                     chart.series[0].redraw();
                     
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                  }
            })
            ;
            
            
    }
</script>


<div class="site-index">
    <input type="hidden" id="selectedOption" name="selectedOption" />
    
    <?php if (!Yii::$app->user->isGuest) { ?>
        <div class="body-content">



            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Laboratory Request</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">


                            <div id="carousel-lab" class="carousel slide" data-ride="carousel" data-interval="false">
                                <ol class="carousel-indicators">

                                    <?php
                                    for ($x = 0; $x < $slideCount; $x++) {
                                        if ($x == 0) {
                                            echo '<li data-target="#carousel-lab" data-slide-to="' . $x . '" class="active"></li>';
                                        } else {
                                            echo '<li data-target="#carousel-lab" data-slide-to="' . $x . '" class=""></li>';
                                        }
                                    }
                                    ?>
                                </ol>


                                <div class="carousel-inner">

                                    <?php
                                    
                                    //$labCount = 2;
                                    $iCounter =$labCount;
                                    if($labCount>4)
                                    {$iCounter = 4;}
                                    else
                                    {$iCounter = $labCount;}
                                    
                                    echo ' <div class="item active">';
                                    for ($i = 0; $i < $iCounter; $i++) {
                                        
                                        if($labCount>= 4)
                                        {
                                        echo '<div class="col-md-3 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$i] . '">';
                                        }
                                        
                                        if($labCount== 3)
                                        {
                                        echo '<div class="col-md-3 col-md-offset-1 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$i] . '">';
                                        }
                                        if($labCount== 2)
                                        {
                                        echo '<div class="col-md-3 col-md-offset-2 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$i] . '">';
                                        }
                                        if($labCount== 1)
                                        {
                                        echo '<div class="col-md-3 col-md-offset-4 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$i] . '">';
                                        }
                                        
                                        echo '<span class="info-box-icon"><i class="' . $listLabIcons[$i] . '"></i></span>';
                                        echo '<div class="info-box-content"><span class="info-box-text">' . $listLab[$i] . '</span>';
                                        echo '<span class="info-box-number"><a href="#" style="color:white">' . $listLabCount[$i] . '</a></span></div></div></div>';
                                    }
                                    echo '</div>';
                                    ?>



                                    <?php
                                    
                                   // $labCount =7;
                                    
                                    if ($slideCount > 1) {
                                        
                                        for ($i = 1; $i < $slideCount; $i++) {
                                            
                                        
                                         $startCounter = 4 * $i;
                                         $newCounter = $labCount - $startCounter;
                                         
                                         //mmecho $slideCount . '-' . $startCounter  . '-' . $newCounter.'-'. $labCount;

                                            echo ' <div class="item">';
                                            $enCount = $startCounter + 4;
                                            if($enCount>$labCount)
                                            {
                                                $enCount = $labCount;
                                            }
                                                 
                                            //if ($enCount > $labCount) {
                                            //    $enCount = $labCount;
                                            //}
                                            for ($j = $startCounter; $j < $enCount; $j++) {
                                                
                                                if($newCounter>= 4)
                                                {
                                                echo '<div class="col-md-3 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$j] . '">';
                                                }

                                                if($newCounter== 3)
                                                {
                                                echo '<div class="col-md-3 col-md-offset-0 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$j] . '">';
                                                }
                                                if($newCounter== 2)
                                                {
                                                echo '<div class="col-md-3  col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$j] . '">';
                                                }
                                                if($newCounter== 1)
                                                {
                                                echo '<div class="col-md-3  col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$j] . '">';
                                                }
                                                
                                                echo '<span class="info-box-icon"><i class="' . $listLabIcons[$j] . '"></i></span>';
                                                echo '<div class="info-box-content"><span class="info-box-text">' . $listLab[$j] . '</span>';
                                                echo '<span class="info-box-number"><a href="/maintenance/" style="color:white">' . $listLabCount[$j] . '</a></span></div></div></div>';
                                            }
                                            echo '</div>';

                                          //  $startCounter = $startCounter + 4;
                                        }
                                    }
                                    ?>

                                </div>


                            </div>
                            <!--
                            <a class="left carousel-control" href="#carousel-lab" data-slide="prev">
                                <span class="fa fa-angle-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-lab" data-slide="next">
                                <span class="fa fa-angle-right"></span>
                            </a>
                            -->
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <div class ="row" name="secondRow">
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-info-circle"></i>

                            <h3 class="box-title">Top 10 Tests/Analysis</h3>
                        </div>

                        <div class="box-body" >

                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">

                                    <li class="dropdown">
                                        <div class="btn-group select" id="dropYear">
                                            <a class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="selected">Select Year</span> <span class="caret"></span></a>


                                            <ul class="dropdown-menu option" role="menu">
                                                <?php 
                                                foreach($listYear as $year)
                                                {
                                                    echo '<li id="1"><a href="#">' . $year . '</a></li>';
                                                }
                                              
                                              ?>
                                            </ul>
                                        </div>

                                    </li>

                                    <li class="dropdown">
                                        <div class="btn-group select" id="dropLaboratory">
                                            <a class="btn btn-default dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="selected">Select Laboratory</span> <span class="caret"></span></a>

                                            <ul class="dropdown-menu option" >
                                                <?php
                                                for ($j = 0; $j < $labCount; $j++) {
                                                    if($listLabCode[$j] != "")
                                                    {
                                                    echo '<li id="' . $j . '"><a href="#' . $listLabCode[$j] . '" data-toggle="tab">' . $listLab[$j] . '</a></li>';
                                                    }
                                                }
                                                ?>              
                                            </ul>
                                        </div>
                                    </li>
                                </ul>

                                <div class="tab-content">

                                    <?php
                                    for ($j = 0; $j < $labCount; $j++) {
                                        if ($j == 0) {
                                            echo '<div class="tab-pane active" id="' . $listLabCode[$j] . '"';
                                        } else {
                                            echo '<div class="tab-pane" id="' . $listLabCode[$j] . '"';
                                        }
                                        echo ' <div class="box"><div class="box-header" style="border-top:3px solid ' . $listLabColor[$j] . '">';
                                        echo '<h3 class="box-title">' . $listLab[$j] . '</h3></div>';
                                        echo '<div class="box-body no-padding">';
                                        echo '<table class="table table-condensed">
                                                                                                        <tbody>'
                                        ?>
                                        <?php
                                        echo '<tr>';
                                        for ($i = 0; $i < count($listColumn); $i++) {
                                            echo '<th>' . $listColumn[$i] . '</th>';
                                        }
                                        echo '<tr>';

                                        $withRowsCounter = 0;
                                        foreach ($dataTop10 as $row) {
                                            if ($row['type'] == $listLab[$j]) {
                                                echo '<tr>
                                                                        <td>' . $row['rank'] . '</td>
                                                                        <td>' . $row['test'] . '</td>
                                                                        <td>' . $row['count'] . '</td>
                                                         </tr>';
                                                $withRowsCounter++;
                                            }
                                        }
                                        
                                        if($withRowsCounter < 10)
                                        {
                                            for ($i = 0; $i < 10- $withRowsCounter; $i++) {
                                                echo '<tr style="height:30px">
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                         </tr>';
                                            }
                                        }
                                        
                                        ?>


                                        <?php
                                        echo '</tbody></table>';
                                        echo '</div></div>';
                                    }

                                    echo '</div>';
                                    ?>


                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>

                    </div>

                    <div class="col-md-8">
                        <div class="box box-default">

                            <!-- /.box-header -->
                            <div class="box-body" >
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">

                                        <li class="dropdown">
                                            <div class="btn-group select" id="dropGraph">
                                                <a class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="selected">Select Graph</span> <span class="caret"></span></a>


                                                <ul class="dropdown-menu option" role="menu" name="selGraph" >
                                                    <li id="1"><a href="#tabgraphColumn" data-toggle="tab" onclick="showDropYear(0,'firms')">Firms Assisted</a></li>
                                                    <li id="2"><a href="#tabgraphColumn" data-toggle="tab" onclick="showDropYear(0,'income')">Income Generated</a></li>
                                                    <li id="3"><a href="#tabgraphColumn" data-toggle="tab" onclick="showDropYear(0,'assistance')">Value of Assistance</a></li>
                                                    <li id="4"><a href="#tabgraphColumn" data-toggle="tab" onclick="showDropYear(0,'calibration')">Testing /Calibration</a></li>
                                                    <li id="5"><a href="#tabgraphColumn" data-toggle="tab" onclick="showDropYear(0,'customer')">Customer</a></li>
                                                    <li id="6"><a href="#graphYearly" onclick="showDropYear(1,'')" data-toggle="tab">Yearly Report</a></li>
                                                    
                                                    <!--  <li id="6"><a href="#graphYearlyTest" onclick="showDropYear(1)" data-toggle="tab">Yearly Test</a></li>
                                                   -->
                                                     
                                                    
                                            </div>
                                        </li>
                                        
                                        <li class="dropdown">
                                        <div class="btn-group select" id="dropYearTwo" style="display:none">
                                            <a class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="selected">Select Year</span> <span class="caret"></span></a>


                                            <ul class="dropdown-menu option" role="menu" id="dropSelectedYear">
                                                <?php 
                                                foreach($listYear as $year)
                                                {
                                                    echo '<li id="1"><a onclick="updateRecord(' . $year  .  ')" href="#panel' . $year . '" data-toggle="tab">' . $year . '</a></li>';
                                                }
                                              
                                              ?>
                                            </ul>
                                        </div>

                                    </li>

                                    </ul>
                                    <div class="tab-content" style="margin-bottom:1px">
                                        <div class="tab-pane active" id="tabgraphColumn">

                                            <div class="box-body">
                                                <div class="box box-success">

                                                    <div class="chart" >
                                                           <?php
                                                echo Highcharts::widget([
                                                    'id' =>'labColumnChart',
                                                    'scripts' => [
                                                        'modules/exporting',
                                                        'themes/grid-light',
                                                    ],
                                                    'options' => [
                                                        'title' => [
                                                            'text' => 'Firms Assisted',
                                                        ],
                                                        'xAxis' => [
                                                                'title' => [
                                                                    'text' => 'Year'
                                                                ],
                                                                'categories' => $listYear,
                                                            ],
                                                        'yAxis' => [
                                                            'title' => [
                                                                'text' => 'No of Firms'
                                                            ]
                                                        ],
                                                        'labels' => [
                                                            'items' => [
                                                                [
                                                                    
                                                                    'style' => [
                                                                        'left' => '50px',
                                                                        'top' => '18px',
                                                                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                                                    ],
                                                                ],
                                                            ],
                                                        ],
                                                          'series' => $data['column']
                                                        
                                                    ]
                                                ]);
                                                ?>
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="tab-pane" id="graphYearly">

                                            <div class="box-body">
                                                <div class="box box-success">

                                                    <div class="chart" >
                                                            
                                                        <?php
                                                            
                                                            
                                                echo Highcharts::widget([
                                                    'id'=>'yearlyPieChart',
                                                    'scripts' => [
                                                        'modules/exporting',
                                                        'themes/grid-light',
                                                    ],
                                                    
                                                    'options' => [
                                                        'chart' =>[
                                                            
                                                            'type'=> 'pie',
                                                            
                                                        ],
                                                        
                                                        'title' => [
                                                            'text' => 'Testing/Calibration Services Rendered by Lab',
                                                        ],
                                                        'credits' => false,
                                                       
                                                        'labels' => [
                                                            'items' => [
                                                                [
                                                                    'html' => '',
                                                                    'style' => [
                                                                        'left' => '50px',
                                                                        'top' => '18px',
                                                                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                                                    ],
                                                                ],
                                                            ],
                                                        ],
                                                        'series' => [
                                                            [
                                                               
                                                                'name' => 'Total consumption',
                                                               
                                                                'data' => $data['pie'],
                                                                'size' => '100%',
                                                                'showInLegend' => true,
                                                                'dataLabels' => [
                                                                    'enabled' => true,
                                                                ],
                                                            ],
                                                        ],
                                                    ]
                                                ]);
                                             
                                                ?>  
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>
                                            </div>

                                        </div>
                                        
                                       
                                        
                                        </div>
                                        
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>









                </div>

                <!--Begin 2 Columns Row -->


                <!--End 2 Columns Row  -->

            </div>
        </div>

<?php } else { ?>
         <?php
            $model = new LoginForm();
            echo $this->render('..\admin-lte\site\userdashboard.php', [
                'model' => $model,
            ]);
            
          ?>
<?php } ?>
