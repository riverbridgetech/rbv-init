<?php
    include('../include/connection.php');
    include('../include/query_helper.php');
    include('../include/common_function.php');

    $json         = file_get_contents('php://input');
    $obj         = json_decode($json);
    
    function sendOtp($mobile_num)
    {
        global $datetime;

        $res_insert_otp = false;

        // chk for already exist
        $row_chk_isExists = check_exist('tbl_otp', array('otp_mobile_number'=>$mobile_num));
        
        $mobile_otp = generateRandomString(6, 'mobile_verification');

        $dataOTP['otp_mobile_otp']    = $mobile_otp;
        $dataOTP['otp_status']        = '1';
        
        if($row_chk_isExists)
        {
            $dataOTP['otp_count']         = (int)$row_chk_isExists['otp_count'] + 1;
            $dataOTP['otp_modified_date'] = $datetime;
            
            $res_update_otp = update('tbl_otp', $dataOTP, array('otp_id'=>$row_chk_isExists['otp_id']));
            
            if($res_update_otp)
            {
                $res_insert_otp = true;
            }
        }
        else
        {
            $dataOTP['otp_mobile_number'] = $mobile_num;
            $dataOTP['otp_created_date']  = $datetime;
            $res_insert_otp = insert('tbl_otp', $dataOTP);
        }

        if($res_insert_otp)
        {
            $data_msg ="Your 6-digit mobile verification code is ".$mobile_otp.". Kindly enter this code to complete the Registration process.";
            // sendMessage($mobile_num,$data_msg);
            
            $dataNotification['nf_type']          = 'Mobile Verification';
            $dataNotification['nf_message']       = $data_msg;
            $dataNotification['nf_mobile_number'] = $mobile_num;
            $dataNotification['nf_created_date']  = $datetime;

            $res_insert_notification = insert('tbl_notification', $dataNotification);
            
            if($res_insert_notification)
            {
                // quit('Success', 1);
                return true;
            }
            else
            {
                // quit('Notification Error');
                return false;
            }
        }
        else
        {
            // quit('Something went wrong, Please try after sometime!');
            return false;
        }
    }

    if((isset($obj->sendOtp)) == "1" && (isset($obj->sendOtp)))
    {
        $mobile_num = $obj->mobile_num;
        $resp = sendOtp($mobile_num);
        // quit($resp);
        if($resp)
        {
            quit('Success', 1);
        }
        else
        {
            quit('Something went wrong, Please try after sometime!');
        }
    }

    if((isset($obj->resend_otp)) == "1" && (isset($obj->resend_otp)))
    {
        $mobile_num            = $obj->mobile_num;
        // first have to check this number in our tbl_otp table
        $row_chk_isMobileNoExists = check_exist('tbl_otp', array('otp_mobile_number'=>$mobile_num, 'otp_status'=>1));
        
        if($row_chk_isMobileNoExists)
        {
            // record found
            // update otp_status to 0
            $res_update_otp_status = update('tbl_otp', array('otp_status'=>0), array('otp_mobile_number'=>$mobile_num, 'otp_status'=>1, 'otp_id'=>$row_chk_isMobileNoExists['otp_id']));
            
            if($res_update_otp_status)
            {
                $resp = sendOtp($mobile_num);
    
                if($resp)
                {
                    quit('Success', 1);
                }
                else
                {
                    quit('Something went wrong, Please try after sometime!');
                }
            }
            else
            {
                quit('Something went wrong, Please try after sometime!');
            }
        }
        else
        {
            $resp = sendOtp($mobile_num);

            if($resp)
            {
                quit('Success', 1);
            }
            else
            {
                quit('Something went wrong, Please try after sometime!');
            }
        }
    }

    if((isset($obj->reset_otp_status)) == "1" && (isset($obj->reset_otp_status)))
    {
        $mobile_num = $obj->mobile_num;

        if($mobile_num != '')
        {
            $row_chk_isMobileNoExists = check_exist('tbl_otp', array('otp_mobile_number'=>$mobile_num, 'otp_status'=>1));
            if($row_chk_isMobileNoExists)
            {
                $res_update_otp_status = update('tbl_otp', array('otp_status'=>0), array('otp_mobile_number'=>$mobile_num));
                
                if($res_update_otp_status)
                {
                    quit('Success', 1);
                }
                else
                {
                    quit('Something went wrong, Please try after sometime!');
                }
            }
            else
            {
                quit('Success', 1);
            }
        }
        else
        {
            quit('Please insert a valid mobile number!');
        }
    }

    if((isset($obj->register_user)) == "1" && (isset($obj->register_user)))
    {
        $user_first_name = $obj->user_first_name;
        $user_last_name  = $obj->user_last_name;
        $user_mobile     = $obj->user_mobile;
        $input_otp       = $obj->input_otp;

        if($user_first_name != '' && $user_last_name != '' && $user_mobile != '' && $input_otp != '')
        {
            // check for correct otp first
            $row_get_otp_data = check_exist('tbl_otp', array('otp_mobile_number'=>$user_mobile, 'otp_status'=>1));

            if($row_get_otp_data)
            {
                if($input_otp == $row_get_otp_data['otp_mobile_otp'])
                {
                    $user_password = generateRandomString(6, 'user_password');
                    $user_salt     = generateRandomString(4, 'user_password');

                    $user_password_md5 = md5($user_password.$user_salt);

                    $registerUserData                                = [];
                    $registerUserData['user_first_name']             = $user_first_name;
                    $registerUserData['user_last_name']              = $user_last_name;
                    $registerUserData['user_email']                  = '';
                    // $registerUserData['user_email_verification']  = '';
                    // $registerUserData['user_mobile']              = $user_mobile;
                    // $registerUserData['user_mobile_verification'] = 1;
                    $registerUserData['user_password']               = $user_password_md5;
                    $registerUserData['user_salt']                   = $user_salt;
                    $registerUserData['user_grade']                  = '';
                    $registerUserData['user_school']                 = '';                    
                    $registerUserData['user_ip_address']             = $client_ip_address;
                    $registerUserData['user_user_agent']             = $_SERVER['HTTP_USER_AGENT'];
                    $registerUserData['user_status']                 = 1;
                    $registerUserData['user_created_date']           = $datetime;

                    $res_insert_user = insert('tbl_users', $registerUserData);
                    
                    $_SESSION['rbv_init_user']                = [];
                    $_SESSION['rbv_init_user']                = $registerUserData;
                    $_SESSION['rbv_init_user']['user_mobile'] = $user_mobile;
                    $_SESSION['rbv_init_user']['user_id']     = $res_insert_user;

                    /**
                     * START : update the respective otp records with the respective user id
                     */
                    $res_update_user_id = update('tbl_otp', array('otp_user_id'=>$res_insert_user), array('otp_id'=>$row_get_otp_data['otp_id']));
                    /**
                     * END
                     */
                    
                    if($res_insert_user && $res_update_user_id)
                    {
                        $data_msg ="Successfully Registered! Your password is ".$user_password;
                        // sendMessage($mobile_num,$data_msg);
                        
                        $dataNotification['nf_type']          = 'Register User';
                        $dataNotification['nf_message']       = $data_msg;
                        $dataNotification['nf_user_id']       = $res_insert_user;
                        $dataNotification['nf_mobile_number'] = $user_mobile;
                        $dataNotification['nf_created_date']  = $datetime;

                        $res_insert_notification = insert('tbl_notification', $dataNotification);
                        
                        if($res_insert_notification)
                        {
                            quit('Success', 1);
                        }
                        else
                        {
                            quit('Something went wrong, Please try after sometime!');
                        }
                    }
                    else
                    {
                        quit('Something went wrong, Please try after sometime!');
                    }
                }
                else
                {
                    quit('OTP not matched!');
                }
            }
            else
            {
                quit('Something went wrong, Please try after sometime!');
            }
        }
        else
        {
            $row_get_otp_data = check_exist('tbl_otp', array('otp_mobile_number'=>$user_mobile, 'otp_status'=>1));

            if($row_get_otp_data)
            {
                $res_update_otp_status = update('tbl_otp', array('otp_status'=>0), array('otp_mobile_number'=>$user_mobile));
            }
            
            quit('Something went wrong, Please try after sometime!');
        }
    }
    
    if((isset($obj->user_login)) == "1" && (isset($obj->user_login)))
    {
        $user_mobile   = $obj->user_mobile;
        $user_password = $obj->user_password;

        if($user_mobile != '' && $user_password != '')
        {
            // check for mobile number
            // $row_get_user_data = check_exist('tbl_users', array('user_mobile'=>$user_mobile, 'user_mobile_verification'=>1));
            $row_get_user_data = check_exist('tbl_otp', array('otp_mobile_number'=>$user_mobile, 'otp_status'=>'1'), array('otp_user_id'=>'0'));
            // quit($row_get_user_data);

            if($row_get_user_data)
            {
                $user_id = $row_get_user_data['otp_user_id'];

                $row_user_password_data = check_exist('tbl_users', array('user_id'=>$user_id, 'user_status'=>1));
                if($row_user_password_data)
                {
                    $password = $row_user_password_data['user_password'];
                    $slat     = $row_user_password_data['user_salt'];
    
                    $u_password = md5($user_password.$slat);
    
                    if($password == $u_password)
                    {
                        $_SESSION['rbv_init_user'] = [];
                        $_SESSION['rbv_init_user'] = $row_user_password_data;
                        $_SESSION['rbv_init_user']['user_mobile'] = $user_mobile;
                        quit('Success', 1);
                    }
                    else
                    {
                        quit('Password not matched!');
                    }
                }
                else
                {
                    quit('Something went wrong, Please try after sometime!');
                }
            }
            else
            {
                quit('Something went wrong, Please try after sometime!');
            }
        }
        else
        {
            quit('Both Mobile number and Password field is required!');
        }
    }

    if((isset($obj->updateUserProfile)) == "1" && (isset($obj->updateUserProfile)))
    {
        $user_id                              = $obj->user_id;
        $dataUserProfile['user_email']        = $obj->user_email;
        $dataUserProfile['user_parents_name'] = $obj->user_parent_name;
        $dataUserProfile['user_grade']        = $obj->user_grade;
        $dataUserProfile['user_school']       = $obj->user_school;
        $dataUserProfile['user_state']        = $obj->user_state;
        $dataUserProfile['user_dist']         = $obj->user_dist;
        $dataUserProfile['user_taluka']       = $obj->user_taluka;
        $dataUserProfile['user_village']      = $obj->user_village;

        if($user_id != '' && $dataUserProfile['user_email'] != '')
        {
            // update user profile data in tbl_users table 
            $res_update_userprofile_data = update('tbl_users', $dataUserProfile, array('user_id'=>$user_id));
            
            if($res_update_userprofile_data)
            {
                quit('Success', 1);
            }
            else
            {
                quit('Something went wrong, Please try after sometime!');
            }
        }
        else
        {
            quit('Something went wrong, Please try after sometime!');
        }
    }

    if((isset($obj->store_user_client_token)) == "1" && (isset($obj->store_user_client_token)))
    {
        $user_id           = $obj->user_id;
        $user_client_token = $obj->user_client_token;
        $client_id         = $obj->client_id;

        if($user_id != '' && $user_client_token != '' && $client_id != '')
        {
            // have to check Already exists
            $row_chk_isExists = check_exist('tbl_user_client_token', array('uct_user_id'=>$user_id, 'uct_client_id'=>$client_id));

            if(!$row_chk_isExists)
            {
                $tokendatetime = new DateTime('now');
                $tokendatetime->modify('+3 month'); 
                $expirydate = $tokendatetime->format('Y-m-d H:i:s');

                // insert one entry for respective user and client
                $insertUserClientToken                           = [];
                $insertUserClientToken['uct_user_id']            = $user_id;
                $insertUserClientToken['uct_client_id']          = $client_id;
                $insertUserClientToken['uct_token']              = $user_client_token;
                $insertUserClientToken['uct_token_created_date'] = $datetime;
                $insertUserClientToken['uct_token_expiry_date']  = $expirydate;
                $insertUserClientToken['uct_status']             = 1;
                $insertUserClientToken['uct_created_date']       = $datetime;
                $res_insert_user_client_token = insert('tbl_user_client_token', $insertUserClientToken);

                if($res_insert_user_client_token)
                {
                    quit('Success', 1);
                }
                else
                {
                    quit('Something went wrong, Please try after sometime!');
                }
            }
            else
            {
                $status = $row_chk_isExists['uct_status'];

                if($status)
                {
                    quit('Success', 1);
                }
                else
                {
                    quit('Something went wrong, Please try after sometime!');
                }
            }
        }
        else
        {
            quit('Something went wrong, Please try after sometime!');
        }
    }

    if((isset($obj->get_section_service_data)) == "1" && (isset($obj->get_section_service_data)))
    {
        $html_data = '';

        $html_data .= '<div class="container">';
            $res_cilent_list = lookup_value('tbl_clients', array(), array('client_status'=>'1', 'client_frontend_flag'=>1),array(), array(), array(), array('client_sort_order'));
            
            $counter = 0;
            $i = 0;
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
                    $html_data .= '<div class="row">';
                    
                }
                $html_data .= '<div class="col-md-4 col-sm-4 services">';
                    $html_data .= $client_name;
                        
                        // check already participated or not
                        $row_chk_participated = check_exist('tbl_user_client_token', array('uct_user_id'=>$_SESSION['rbv_init_user']['user_id'], 'uct_client_id'=>$client_id));
                                
                        if($row_chk_participated)
                        {
                            $uct_status = $row_chk_participated['uct_status'];

                            if($uct_status) // Status == 1
                            {
                                // chk expiry date
                                // if not expired show "GO TO" btn
                                $html_data .= '<a href="'.$client_micro_link.'" class="btn btn-primary" target="_blank">Go To</a>';
                                    
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

                            $html_data .= '<a href="javascript:void(0);" class="btn btn-primary" onClick="getParticipate('.$_SESSION['rbv_init_user']['user_id'].', \''.$user_client_token.'\', '.$client_id.', \''.$client_micro_link.'\', \''.$client_api_link.'\');">Activate</a>';
                        }                                                    
                $html_data .= '</div>';
                if($counter == 3)
                {
                    $counter = 0;
                    $html_data .= '</div>';
                }  
                $i++;                                          
            }                                        
        $html_data .= '</div>';

        quit($html_data, 1);
    }

    if((isset($obj->get_dist)) == "1" && (isset($obj->get_dist)))
    {
        $state_id = $obj->state_id;

        if($state_id != '')
        {
            $html_data = '';
            $html_data .= '<select name="user_dist" id="user_dist" class="form-control" onchange="getTaluka(this.value);">';
                $res_get_dist_list = lookup_value('tbl_district', array(), array('dt_stid'=>$state_id),array(), array(), array(), array('id'));
                if($res_get_dist_list)
                {
                    $html_data .= '<option value="">Select District</option>';
                    while ($row_get_dist_list = mysqli_fetch_array($res_get_dist_list)) 
                    {
                        $html_data .= '<option value="'.$row_get_dist_list['id'].'">'.ucwords($row_get_dist_list['dt_name']).'</option>';
                    }
                }
                else
                {
                    $html_data .= '<option value="">No Data Found</option>';
                }
            $html_data .= '</select>';

            quit($html_data, 1);
        }
        else
        {
            quit('Something went wrong, Please try after sometime!');
        }
    }

    if((isset($obj->get_taluka)) == "1" && (isset($obj->get_taluka)))
    {
        $dist_id = $obj->dist_id;

        if($dist_id != '')
        {
            $html_data = '';
            $html_data .= '<select name="user_taluka" id="user_taluka" class="form-control" onchange="getVillage(this.value);">';
                $res_get_taluka_list = lookup_value('tbl_taluka', array(), array('tk_dtid'=>$dist_id),array(), array(), array(), array('id'));
                if($res_get_taluka_list)
                {
                    $html_data .= '<option value="">Select Taluka</option>';
                    while ($row_get_taluka_list = mysqli_fetch_array($res_get_taluka_list)) 
                    {
                        $html_data .= '<option value="'.$row_get_taluka_list['id'].'">'.ucwords($row_get_taluka_list['tk_name']).'</option>';
                    }
                }
                else
                {
                    $html_data .= '<option value="">No Data Found</option>';
                }
            $html_data .= '</select>';

            quit($html_data, 1);
        }
        else
        {
            quit('Something went wrong, Please try after sometime!');
        }
    }

    if((isset($obj->get_village)) == "1" && (isset($obj->get_village)))
    {
        $taluka_id = $obj->taluka_id;

        if($taluka_id != '')
        {
            $html_data = '';
            $html_data .= '<select name="user_village" id="user_village" class="form-control">';
                $res_get_village_list = lookup_value('tbl_village', array(), array('vl_tkid'=>$taluka_id),array(), array(), array(), array('id'));
                if($res_get_village_list)
                {
                    $html_data .= '<option value="">Select Village</option>';
                    while ($row_get_village_list = mysqli_fetch_array($res_get_village_list)) 
                    {
                        $html_data .= '<option value="'.$row_get_village_list['id'].'">'.ucwords($row_get_village_list['vl_name']).'</option>';
                    }
                }
                else
                {
                    $html_data .= '<option value="">No Data Found</option>';
                }
            $html_data .= '</select>';

            quit($html_data, 1);
        }
        else
        {
            quit('Something went wrong, Please try after sometime!');
        }
    }
?>