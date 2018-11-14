<?php
use yii2assets\pdfjs\PdfJs;
/* 
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 23 May, 2018 , 12:31:20 AM * 
 * Module: preview * 
 */
$this->title = 'Preview';
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['/reports']];
$this->params['breadcrumbs'][] ="Preview";
?>
<div style="margin-left: -10px;margin-top: -13px;margin-right: -10px">
<?= PdfJs::widget([
    'width'=>'100%',
    'height'=> '670px',
    'url'=>$url
]); ?>
</div>
