<?php
    include('../include/connection.php');
    include('../include/query_helper.php');
    include('../include/common_function.php');

    $json 	= file_get_contents('php://input');
    $obj 	= json_decode($json);
    
    function sendOtp($mobile_num)
    {
        global $datetime;

        $mobile_otp = generateRandomString(6, 'mobile_verification');

        $dataOTP['otp_mobile_number'] = $mobile_num;
        $dataOTP['otp_mobile_otp']    = $mobile_otp;
        $dataOTP['otp_status']        = 1;
        $dataOTP['otp_created_date']  = $datetime;

        $res_insert_otp = insert('tbl_otp', $dataOTP);
        
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
        $res_update_otp_status = true;
        // first have to check this number in our tbl_otp table
        $row_chk_isMobileNoExists = check_exist('tbl_otp', array('otp_mobile_number'=>$mobile_num, 'otp_status'=>1));

        if($row_chk_isMobileNoExists)
        {
            // record found
            // update otp_status to 0
            $res_update_otp_status = update('tbl_otp', array('otp_status'=>0), array('otp_mobile_number'=>$mobile_num, 'otp_status'=>1, 'otp_id'=>$row_chk_isMobileNoExists['otp_id']));
        }

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
        $user_name   = $obj->user_name;
        $user_mobile = $obj->user_mobile;
        $input_otp   = $obj->input_otp;

        if($user_name != '' && $user_mobile != '' && $input_otp != '')
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

                    $registerUserData                             = [];
                    $registerUserData['user_name']                = $user_name;
                    $registerUserData['user_email']               = '';
                    $registerUserData['user_email_verification']  = '';
                    $registerUserData['user_mobile']              = $user_mobile;
                    $registerUserData['user_mobile_verification'] = 1;
                    
                    $registerUserData['user_password']            = $user_password_md5;
                    $registerUserData['user_salt']                = $user_salt;

                    $registerUserData['user_grade']               = '';
                    $registerUserData['user_school']              = '';
                    $registerUserData['user_status']              = 1;
                    $registerUserData['user_created_date']        = $datetime;

                    $res_insert_user = insert('tbl_users', $registerUserData);
                    
                    $_SESSION['rbv_init_user']            = [];
                    $_SESSION['rbv_init_user']            = $registerUserData;
                    $_SESSION['rbv_init_user']['user_id'] = $res_insert_user;
                    
                    if($res_insert_user)
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
            quit('Something went wrong, Please try after sometime!');
        }
    }
?>