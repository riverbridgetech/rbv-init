function onlyNumbers(val)
{
    // console.log(val);
    if(val.length == 10)
    {
        if (/^\d{10}$/.test(val)) 
        {
            // value is ok, use it
            return true;
        } 
        else 
        {
            alert("Invalid number; must be ten digits")
            $('#'+id).val('');
            return false;
        }
    }
}

function sendOtp(mobile_num)
{
    res = onlyNumbers(mobile_num);
    if(res)
    {
        /* 1: conf to send otp to this mobile number
            if yes 
                then only send the otp to this number
            else 
                not
        */
        confResult = confirm("OTP will be sent to this number: " + mobile_num);
        if(confResult)
        {
            var sendInfo  = {"mobile_num":mobile_num, "sendOtp":1};
            var sendOtp = JSON.stringify(sendInfo);
            
            $.ajax({
                type: "POST",
                url: "controller/load_custom.php",
                data: sendOtp,
                processData: false,
                contentType: false,
                cache: false,
                success: function(msg)
                {
                    data = JSON.parse(msg);
                    console.log(data);
                    if(data.Success == "Success")
                    {
                        $('#input-otp').css('display','block');
                        return false;
                    }
                    else if(data.Success == "fail") 
                    {
                        alert(data.resp);
                    }	
                },
                error: function (request, status, error)
                {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);	
                },
                complete: function()
                {
                    //loading_hide();	
                }	
            });
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

function reg_user()
{
    
}