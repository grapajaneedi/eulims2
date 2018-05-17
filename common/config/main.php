<?php
$components = array_merge(
    require(__DIR__ . '/db.php'),
    require(__DIR__ . '/components.php')
);
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'gridview' => ['class' => 'kartik\grid\Module'],
        'datecontrol' =>  [
            'class' => '\kartik\datecontrol\Module'
        ],
        'reportico' => [
            'class' => 'reportico\reportico\Module',
            'controllerMap' => [
                'reportico' => 'reportico\reportico\controllers\ReporticoController',
                'mode' => 'reportico\reportico\controllers\ModeController',
                'ajax' => 'reportico\reportico\controllers\AjaxController',
            ]
        ],
    ],
    
    'components' => $components
];
