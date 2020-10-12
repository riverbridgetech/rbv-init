<?php
    date_default_timezone_set('Asia/Kolkata');
    // ini_set('session.cookie_domain', substr($_SERVER['SERVER_NAME'], strpos($_SERVER['SERVER_NAME'],"."), 100));
    // ini_set('session.gc_maxlifetime',11000); 
    // ini_set('session.cookie_lifetime',11000);
    
    session_start();
    
    $dbname = "rbv_init";
    $dbuser = "rbv_init";
    $dbpass = "rbv_init@!2020";
    
    $date 	  = new DateTime(null, new DateTimeZone('Asia/Kolkata'));
    $datetime = $date->format('Y-m-d H:i:s');
    
    if ($_SERVER['HTTP_HOST'] == "localhost" || preg_match("/^192\.168\.1.\d+$/",$_SERVER['HTTP_HOST']) || preg_match("/^praful$/",$_SERVER['HTTP_HOST'])) 
    {
        $dbname = "rbv_init";
        $dbuser = "root";
        $dbpass = "";
    }
    
    $db_con = mysqli_connect("localhost",$dbuser, $dbpass) or die("Cannot connect to database");

    if($db_con)
    {
        mysqli_select_db($db_con,$dbname) or die(mysqli_error($db_con));
    }
    else
    {
        echo mysqli_error($db_con);
    }
    
    $BaseFolder = "https://www.mastermindscompetition.com/";
    if ($_SERVER['HTTP_HOST'] == "localhost" || preg_match("/^192\.168\.2.\d+$/",$_SERVER['HTTP_HOST']) || preg_match("/^praful$/",$_SERVER['HTTP_HOST']) || preg_match("/^jay$/",$_SERVER['HTTP_HOST'])) 
    {
        $BaseFolder = "http://localhost/rbv-init/";
    }
    
    define('BASE_FOLDER',$BaseFolder);
?>