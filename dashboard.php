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
                &nbsp;
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
                                            <h4>Complete your profile to gain access</h4>
                                            <form method="POST" enctype="multipart/form-data" class='form-validate' id="frm_user_profile" name="frm_user_profile" autocomplete="off">

                                                <input type="hidden" name="hid_user_id" id="hid_user_id" value="<?php echo $_SESSION['rbv_init_user']['user_id']; ?>">
                                                
                                                <input type="email" class="form-control" placeholder="Email-ID" id="user_email" name="user_email" autocomplete="off" required>
                                                
                                                <input type="text" class="form-control" placeholder="Parent's Name" id="user_parent_name" name="user_parent_name" autocomplete="off" >

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

                                                <select name="user_state" id="user_state" class="form-control" onchange="getDist(this.value);">
                                                    <?php
                                                    $res_get_state_list = lookup_value('tbl_state', array(), array('st_status'=>'1'),array(), array(), array(), array('id'));
                                                    if($res_get_state_list)
                                                    {
                                                        ?>
                                                        <option value="">Select State</option>
                                                        <?php
                                                        while ($row_get_state_list = mysqli_fetch_array($res_get_state_list)) 
                                                        {
                                                            ?>
                                                            <option value="<?php echo $row_get_state_list['id'] ?>"><?php echo ucwords($row_get_state_list['st_name']); ?></option>
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

                                                <div id="div_dist">
                                                    <select name="user_dist" id="user_dist" class="form-control" onchange="getTaluka(this.value);" disabled>
                                                        <option value="">Select District</option>
                                                    </select>
                                                </div>
                                                
                                                <div id="div_taluka">
                                                    <select name="user_taluka" id="user_taluka" class="form-control" onchange="getVillage(this.value);" disabled>
                                                        <option value="">Select Taluka</option>
                                                    </select>                                                    
                                                </div>

                                                <div id="div_village">
                                                    <select name="user_village" id="user_village" class="form-control" disabled>
                                                        <option value="">Select Village</option>
                                                    </select>
                                                </div>



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
                        
                    ?>
                    <section id="section_services">
                        
                    </section>
                </div>
            </div>
            <?php include("rbv_footer.php"); ?>
        </div>
        <?php include("rbv_modal.php"); ?>
        <?php include("rbv_javascript.php"); ?>
        <script>
            <?php
            if($user_email != '')
            {
                ?>
                $( document ).ready(function() {
                    getSectionServiceData();
                });                
                <?php
            }
            ?>
        </script>
    </body>
</html>