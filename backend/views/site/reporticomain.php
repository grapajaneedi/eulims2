<?php



 $reportico = \Yii::$app->getModule('reportico');
        $engine = $reportico->getReporticoEngine();        // Fetches reportico engine
        $engine->access_mode = "FULL";                     // Allows access to all Reportico pages
        $engine->initial_execute_mode = "ADMIN";           // Starts user in administration page
        $engine->initial_project = "admin";                // Required for access to admin mode
        $engine->bootstrap_styles = "3";                   // Set to "3" for bootstrap v3, "2" for V2 or false for no bootstrap
        $engine->force_reportico_mini_maintains = true;    // Often required
        $engine->bootstrap_preloaded = true;               // true if you dont need Reportico to load its own bootstrap
        $engine->clear_reportico_session = true;           // Normally required
        $engine->execute();                                // Run Reportico


/* 
 * Project Name: eulims * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 05 17, 18 , 1:32:35 PM * 
 * Module: reporticomain * 
 */

