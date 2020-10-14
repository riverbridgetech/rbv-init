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

    if((isset($obj->user_login)) == "1" && (isset($obj->user_login)))
    {
        $user_mobile   = $obj->user_mobile;
        $user_password = $obj->user_password;

        if($user_mobile != '' && $user_password != '')
        {
            // check for mobile number
            $row_get_user_data = check_exist('tbl_users', array('user_mobile'=>$user_mobile, 'user_mobile_verification'=>1));

            if($row_get_user_data)
            {
                $password = $row_get_user_data['user_password'];
                $slat     = $row_get_user_data['user_salt'];

                $u_password = md5($user_password.$slat);

                if($password == $u_password)
                {
                    $_SESSION['rbv_init_user'] = [];
                    $_SESSION['rbv_init_user'] = $row_get_user_data;

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
            quit('Both Mobile number and Password field is required!');
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
?>