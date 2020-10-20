<?php
    include('include/connection.php');
    include('include/query_helper.php');
    include('include/common_function.php');

    function getAreaID($table, $where)
    {
        $row_get_area_id = check_exist($table, $where);

        if($row_get_area_id)
        {
            return $row_get_area_id['id'];
        }
        else
        {
            return false;
        }
    }

    $bulk_user_state   = false;
    $bulk_user_dist    = false;
    $bulk_user_taluka  = false;
    $bulk_user_village = false;

    // get the records form "tbl_bulk_user_upload" table where status = 0
    $res_get_records = lookup_value('tbl_bulk_user_upload', array(), array('insert_status'=>0));

    if($res_get_records)
    {
        while($row_get_records = mysqli_fetch_array($res_get_records))
        {
            $mobile_length = strlen($row_get_records['mobile_number']);

            if($mobile_length == 10)
            {
                $error_log = [];
                // chk for already exist
                $row_chk_isExists = check_exist('tbl_otp', array('otp_mobile_number'=>$row_get_records['mobile_number']));
    
                if($row_chk_isExists)
                {
                    array_push($error_log, 'Mobile number is already exists in otp table.');
                    $res_update_bulk_user_table = update('tbl_bulk_user_upload', array('error_msg'=>json_encode($error_log)), array('id'=>$row_get_records['id']));
                }
                else
                {
                    $row_user_grade   = check_exist('tbl_standards', array('std_value'=>$row_get_records['grade']));
                    if($row_user_grade)
                    {
                        $bulk_user_grade = $row_user_grade['std_promocode'];                    
                    }
                    else
                    {
                        array_push($error_log, 'Error In Grade.');
                    }
    
                    $bulk_user_state   = getAreaID('tbl_state', array('st_name'=>$row_get_records['state']));
                    if($bulk_user_state)
                    {
                        $bulk_user_dist    = getAreaID('tbl_district', array('dt_name'=>$row_get_records['dist'], 'dt_stid'=>$bulk_user_state));
                    }
                    else
                    {
                        array_push($error_log, 'Error in State.');
                    }
    
                    if($bulk_user_dist)
                    {
                        $bulk_user_taluka  = getAreaID('tbl_taluka', array('tk_name'=>$row_get_records['taluka'], 'tk_dtid'=>$bulk_user_dist));
                    }
                    else
                    {
                        array_push($error_log, 'Error in District.');
                    }
                    
                    if($bulk_user_taluka)
                    {
                        $bulk_user_village = getAreaID('tbl_village', array('vl_name'=>$row_get_records['village'], 'vl_tkid'=>$bulk_user_taluka));
                    }
                    else
                    {
                        array_push($error_log, 'Error in Taluka.');
                    }
    
                    if(!$bulk_user_village)
                    {
                        array_push($error_log, 'Error in Village.');
                    }
                    
                    $mobile_otp = generateRandomString(6, 'mobile_verification');
    
                    $dataOTP['otp_mobile_otp']    = $mobile_otp;
                    $dataOTP['otp_status']        = '1';
                    $dataOTP['otp_mobile_number'] = $row_get_records['mobile_number'];
                    $dataOTP['otp_created_date']  = $datetime;
                    $dataOTP['otp_user_type']     = 'bulk';
    
                    $res_insert_otp = insert('tbl_otp', $dataOTP);
                    
                    if($res_insert_otp)
                    {
                        $user_password = generateRandomString(6, 'user_password');
                        $user_salt     = generateRandomString(4, 'user_password');
    
                        $user_password_md5 = md5($user_password.$user_salt);
    
                        $registerUserData                      = [];
                        $registerUserData['user_first_name']   = $row_get_records['first_name'];
                        $registerUserData['user_last_name']    = $row_get_records['last_name'];
                        $registerUserData['user_parents_name'] = $row_get_records['parents_name'];
                        $registerUserData['user_email']        = $row_get_records['email_id'];
                        $registerUserData['user_password']     = $user_password_md5;
                        $registerUserData['user_salt']         = $user_salt;
                        if($bulk_user_grade)
                        {
                            $registerUserData['user_grade']    = $bulk_user_grade;
                        }
                        $registerUserData['user_school']       = $row_get_records['school'];
                        if($bulk_user_state)
                        {
                            $registerUserData['user_state']    = $bulk_user_state;
                        }
                        if($bulk_user_dist)
                        {
                            $registerUserData['user_dist']     = $bulk_user_dist;
                        }
                        if($bulk_user_taluka)
                        {
                            $registerUserData['user_taluka']   = $bulk_user_taluka;
                        }
                        if($bulk_user_village)
                        {
                            $registerUserData['user_village']  = $bulk_user_village;
                        }
                        $registerUserData['user_status']       = 1;
                        $registerUserData['user_created_date'] = $datetime;
    
                        $res_insert_user = insert('tbl_users', $registerUserData);
                        if($res_insert_user)
                        {
                            $res_update_user_id = update('tbl_otp', array('otp_user_id'=>$res_insert_user), array('otp_id'=>$res_insert_otp));
    
                            $data_msg ="Successfully Registered! Your password is ".$user_password;
                            // sendMessage($mobile_num,$data_msg);
                            
                            $dataNotification['nf_type']          = 'Register User';
                            $dataNotification['nf_message']       = $data_msg;
                            $dataNotification['nf_user_id']       = $res_insert_user;
                            $dataNotification['nf_mobile_number'] = $row_get_records['mobile_number'];
                            $dataNotification['nf_created_date']  = $datetime;
    
                            $res_insert_notification = insert('tbl_notification', $dataNotification);
                            
                            $res_update_bulk_users_status = update('tbl_bulk_user_upload', array('insert_status'=>1), array('id'=>$row_get_records['id']));
    
                            if(!$res_insert_notification)
                            {
                                array_push($error_log, 'Error in Notification Insertion.');
                            }                        
                        }
                        else
                        {
                            
                            array_push($error_log, 'Error in User Insertion.');
                        }
                        
                        if(sizeof($error_log))
                        {
                            $res_update_bulk_user_table = update('tbl_bulk_user_upload', array('error_msg'=>json_encode($error_log)), array('id'=>$row_get_records['id']));
                        }
                    }
                    else
                    {
                        array_push($error_log, 'Error while inserting into OTP table.');
                        $res_update_bulk_user_table = update('tbl_bulk_user_upload', array('error_msg'=>json_encode($error_log)), array('id'=>$row_get_records['id']));
                    }
                }
            }
            else
            {
                array_push($error_log, 'Mobile number is invalid.');
                $res_update_bulk_user_table = update('tbl_bulk_user_upload', array('error_msg'=>json_encode($error_log)), array('id'=>$row_get_records['id']));
            }

        }
    }
    else
    {
        echo 'No any records found';
        exit();
    }
?>