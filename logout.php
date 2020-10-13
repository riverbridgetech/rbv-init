<?php 
    include('include/connection.php');
    $_SESSION['rbv_init_user'] = array();
    session_destroy();
    header("Location: ".BASE_FOLDER);
    exit(0);
?>