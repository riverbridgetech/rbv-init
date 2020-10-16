<?php
    include('include/connection.php');
    include('include/query_helper.php');

    if(!isset($_SESSION['rbv_init_user']))
    {
        header("Location:".BASE_FOLDER."");
        exit();
    }
    // else
    // {
        // var_dump($_SESSION['rbv_init_user']);
    // }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic Page Needs -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Riverbridge Initiatives</title>
        <meta name="description" content="Riverbridge Initiatives">
        <meta name="keywords" content="Riverbridge Initiatives,RBV Initiatives, Initiatives">
        <meta name="author" content="Punit Panchal">

        <?php include("rbv_head.php"); ?>

        <style>
        
            .services
            {
                border: 1px solid #000;
                border-radius: 25px;
                height: 300px;
                margin: 7px;
                width: 32%;
            }

        </style>
    </head>
    <body class="home">
        <div class="body">
            <!-- Site Header Wrapper -->
            <div id="section-home" class="site-header-wrapper">
                <?php include("rbv_header.php"); ?>
            </div>
            <div class="hero-area">
                <?php include("rbv_slider.php"); ?>
            </div>

            <div id="main-container">
                <div class="content">
                    <?php
                        // set the flag for showing the user profile or not
                        $row_get_user_details = check_exist('tbl_users', array('user_id'=>$_SESSION['rbv_init_user']['user_id'], 'user_status'=>1));
                        // var_dump($row_get_user_details);

                        $user_email = $row_get_user_details['user_email'];

                        if($user_email == '')
                        {
                            ?>
                            <section id="section_user_profile">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2">
                                            &nbsp;
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            <h4>User Profile</h4>
                                            <form method="POST" enctype="multipart/form-data" class='form-validate' id="frm_user_profile" name="frm_user_profile" autocomplete="off">

                                                <input type="hidden" name="hid_user_id" id="hid_user_id" value="<?php echo $_SESSION['rbv_init_user']['user_id']; ?>">
                                                <input type="email" class="form-control" placeholder="Email-ID" id="user_email" name="user_email" autocomplete="off" required>
                                                
                                                <select name="ddl_grade_list" id="ddl_grade_list" class="form-control">
                                                    <?php
                                                    $res_get_std_list = lookup_value('tbl_standards', array(), array('std_status'=>'1'),array(), array(), array(), array('std_sort_order'));
                                                    if($res_get_std_list)
                                                    {
                                                        ?>
                                                        <option value="">Select Grade</option>
                                                        <?php
                                                        while ($row_get_std_list = mysqli_fetch_array($res_get_std_list)) 
                                                        {
                                                            ?>
                                                            <option value="<?php echo $row_get_std_list['std_promocode'] ?>"><?php echo $row_get_std_list['std_value'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <option value="">No Grades Found</option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                                <input type="text" class="form-control" placeholder="School Name" id="user_school" name="user_school" autocomplete="off" >

                                                <!-- <button type="button" class="btn btn-primary" onClick="getLogin();">Login now</button> -->
                                                <button type="submit" class="btn btn-primary" >Continue</button>
                                                <!-- <input type="submit" value="Login now" class='btn btn-primary'> -->
                                            
                                            </form>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </section>        
                            <?php
                        }
                        else
                        {
                            ?>
                            <section id="section_services">
                                <div class="container">
                                    <?php
                                        $res_cilent_list = lookup_value('tbl_clients', array(), array('client_status'=>'1', 'client_frontend_flag'=>1),array(), array(), array(), array('client_sort_order'));
                                        
                                        $counter = 0;
                                        $i = 0;
                                        $html_data = '';
                                        while ($row_cilent_list = mysqli_fetch_array($res_cilent_list)) 
                                        {
                                            $client_id         = $row_cilent_list['client_id'];
                                            $client_name       = $row_cilent_list['client_name'];
                                            $client_micro_link = $row_cilent_list['client_micro_link'];
                                            $client_api_link   = $row_cilent_list['client_api_link'];
                                            $client_desc_1     = $row_cilent_list['client_desc_1'];
                                            $client_desc_2     = $row_cilent_list['client_desc_2'];
                                            $client_img_1      = $row_cilent_list['client_img_1'];
                                            $client_img_2      = $row_cilent_list['client_img_2'];
                                            $client_sort_order = $row_cilent_list['client_sort_order'];

                                            $counter++;
                                            if($i%3==0)
                                            {
                                                ?>
                                                <div class="row">
                                                <?php
                                            }
                                            ?>
                                            <div class="col-md-4 col-sm-4 services">
                                                <?php 
                                                    echo $client_name;
                                                    
                                                    // check already participated or not
                                                    $row_chk_participated = check_exist('tbl_user_client_token', array('uct_user_id'=>$_SESSION['rbv_init_user']['user_id'], 'uct_client_id'=>$client_id));
                                                            
                                                    if($row_chk_participated)
                                                    {
                                                        $uct_status = $row_chk_participated['uct_status'];

                                                        if($uct_status) // Status == 1
                                                        {
                                                            // chk expiry date
                                                            // if not expired show "GO TO" btn
                                                            ?>
                                                            <a href="<?php echo $client_micro_link; ?>" class="btn btn-primary" target="_blank">Go To</a>
                                                            <?php
                                                              
                                                            // else renew the token
                                                            // ask Punit sir for further process
                                                        }
                                                        else    // status == 0
                                                        {
                                                            // pending [ask punit sir]
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $userid            = (string)$_SESSION['rbv_init_user']['user_id'];
                                                        $clientid          = (string)$client_id;
                                                        $user_client_token = md5($userid.$clientid);

                                                        ?>
                                                        <a href="javascript:void(0);" class="btn btn-primary" onClick="getParticipate(<?php echo $_SESSION['rbv_init_user']['user_id']; ?>, '<?php echo $user_client_token; ?>', <?php echo $client_id; ?>, '<?php echo $client_micro_link; ?>', '<?php echo $client_api_link; ?>');">Participated</a>
                                                        <?php
                                                    }                                                    
                                                ?>                                                
                                            </div>
                                            <?php
                                            if($counter == 3)
                                            {
                                                $counter = 0;
                                                ?>
                                                </div>
                                                <?php
                                            }  
                                            $i++;                                          
                                        }                                        
                                    ?>
                                </div>
                            </section>                            
                            <?php
                        }
                    ?>
                </div>
            </div>
            <?php include("rbv_footer.php"); ?>
        </div>
        <?php include("rbv_modal.php"); ?>
        <?php include("rbv_javascript.php"); ?>
    </body>
</html>