<?php

/**
 * @link https://github.com/brussens/yii2-maintenance-mode
 * @copyright Copyright (c) 2017 Brusensky Dmitry
 * @license http://opensource.org/licenses/MIT MIT
 */
use yii\helpers\Html;

/**
 * Default view of maintenance mode component for Yii framework 2.x.x version.
 *
 * @since 0.2.0
 * @author Brusensky Dmity <brussens@nativeweb.ru>
 */
/** @var $title string */
/** @var $message string */
//$Session=Yii::$app->session;
//$mMessage=$Session->get('mMessage');
?>

<div class="row" style=" background: linear-gradient(to bottom right, #3c8dbc, #b1d1e4);" >
    <div class="jumbotron d-flex align-items-center" style="border:10px dashed #3c8dbc; margin:5%;background-color:lightgray" >
        
        <i class="fa fa-warning " style="font-size: 150px;color: #3c8dbc; "></i>
        <h2>Website under maintenance</h2>
        <div>
            <p>This site is undergoing system upgrade to enhanced the system.</p>
            <div class="row">
                <div class="col-sm-4">.col-sm-4x</div>
                <div class="col-sm-4">.col-sm-4</div>
                <div class="col-sm-4">.col-sm-4</div>
            </div> 
        
        </div>
    </div>
</div>

