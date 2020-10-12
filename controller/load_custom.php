<?php
    include('../include/connection.php');
    include('../include/query_helper.php');
    include('../include/common_function.php');

    $json 	= file_get_contents('php://input');
    $obj 	= json_decode($json);

    if((isset($obj->sendOtp)) == "1" && (isset($obj->sendOtp)))
    {
        $mobile_num = $obj->mobile_num;
        $mobile_otp = generateRandomStringMobileVerification(6);

        $dataOTP['mobile_number'] = $mobile_num;
        $dataOTP['mobile_otp']    = $mobile_otp;
        $dataOTP['created_date']  = $datetime;

        $res_insert_otp = insert('tbl_otp', $dataOTP);
        
        if($res_insert_otp)
        {
            $data_msg ="Your 6-digit mobile verification code is ".$mobile_otp.". Kindly enter this code to complete the Registration process.";
            // sendMessage($mobile_num,$data_msg);
            
            $dataNotification['type'] = 'Mobile Verification';
            $dataNotification['message'] = $data_msg.' - '.$mobile_num;
            $dataNotification['created_date'] = $datetime;

            $res_insert_notification = insert('tbl_notification', $dataNotification);
            
            if($res_insert_notification)
            {
                quit('Success', 1);
            }
            else
            {
                quit('Notification Error');
            }
        }
        else
        {
            quit('OTP Insert Error!');
        }

        quit($mobile_num.' => '.$mobile_otp);
    }
?>