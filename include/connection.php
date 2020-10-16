<?php
    date_default_timezone_set('Asia/Kolkata');
    // ini_set('session.cookie_domain', substr($_SERVER['SERVER_NAME'], strpos($_SERVER['SERVER_NAME'],"."), 100));
    // ini_set('session.gc_maxlifetime',11000); 
    // ini_set('session.cookie_lifetime',11000);
    
    session_start();
    
    $date 	  = new DateTime(null, new DateTimeZone('Asia/Kolkata'));
    $datetime = $date->format('Y-m-d H:i:s');
    
    if ($_SERVER['HTTP_HOST'] == "localhost" || preg_match("/^192\.168\.0.\d+$/",$_SERVER['HTTP_HOST'])) 
	{
        $dbserver = "localhost"; // Database Server
        $dbuname = "root"; // Database Username
        $dbpass = ""; // Database Password
        $dbname = "rbv_init"; // Database Name
        $BaseFolder = "http://localhost/rbv-init/";
	}
	else
	{
        $dbserver   = "localhost"; // Database Server
        $dbuname    = "rbv_init"; // Database Username
        $dbpass     = "rbv_init@!2020"; // Database Password
        $dbname     = "rbv_init"; // Database Name
        $BaseFolder = "http://localhost/rbv-init/"; // BaseFolder Path have to write here 
       
	}

    // $db_con = mysqli_connect("localhost",$dbuser, $dbpass) or die("Cannot connect to database");
    $db_con = new mysqli($dbserver, $dbuname, $dbpass, $dbname);

    if($db_con === false){
        die("ERROR: Could not connect. " . $db_con->connect_error);
    }
    else
    {
        // $_SESSION['rbv_init_user'] 	= "";
		define('BASE_FOLDER',$BaseFolder);
    }

    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    $client_ip_address = get_client_ip();

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    // get the page name
    $arr_url_parts = explode('/', $actual_link);
    $page_name = $arr_url_parts[sizeof($arr_url_parts)-1];
    
?>