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
                        $('#div_reg_otp').css('display','block');
                        $('#input-otp').val('');
                        $('#Resendbtn').hide();
                        $('#countdown').show();
                        otpCounter();
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

function otpCounter()
{
    // var timer2   = "3:00";
    var timer2   = "00:10";
    var interval = setInterval(function() {
    var timer    = timer2.split(':');
    //by parsing integer, I avoid all extra string processing
    var minutes  = parseInt(timer[0], 10);
    var seconds  = parseInt(timer[1], 10);
    --seconds;
    minutes      = (seconds < 0) ? --minutes : minutes;
    seconds      = (seconds < 0) ? 59 : seconds;
    seconds      = (seconds < 10) ? '0' + seconds : seconds;
    //minutes    = (minutes < 10) ?  minutes : minutes;
    $('#countdown').html(minutes + ':' + seconds);
    
    if (minutes < 0) 
    {
        clearInterval(interval);
        resetOtpStatus();   
    }
    
    //check if both minutes and seconds are 0
    
    if ((seconds <= 0) && (minutes <= 0)) 
    {
        clearInterval(interval);
        $('#countdown').hide();
        $('#Resendbtn').show();
        resetOtpStatus();   
    } 
    timer2 = minutes + ':' + seconds;
    }, 1000);
}

function resendOtp() 
{
    let mobile_num = $('#reg_mobile_num').val();
    
    var sendInfo   = {"mobile_num":mobile_num, "resend_otp":1};
    var otp_resend = JSON.stringify(sendInfo);
    
    $.ajax({
        type: "POST",
        url: "controller/load_custom.php",
        data: otp_resend,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function() {
            // $('#button-resend-otp').button('loading');
        },
        success: function(msg)
        {
            data = JSON.parse(msg);
            
            if(data.Success == "Success")
            {
                $('#div_reg_otp').css('display','block');
                $('#input-otp').val('');
                $('#Resendbtn').hide();
                $('#countdown').show();
                otpCounter();
                return false;
            }
            else if(data.Success == "fail") 
            {
                alert(data.resp);
                return false;
            }	
        },
        error: function (request, status, error)
        {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);	
        },
        complete: function()
        {
            $('#button-resend-otp').button('reset');	
        }	
    });
}

function resetOtpStatus()
{
    let mobile_num = $('#reg_mobile_num').val();
    
    if(mobile_num.length < 10)
    {
        alert('Please insert a valid mobile number!');
        return false;
    }
    
    var sendInfo   = {"mobile_num":mobile_num, "reset_otp_status":1};
    var otp_reset = JSON.stringify(sendInfo);
    
    $.ajax({
        type: "POST",
        url: "controller/load_custom.php",
        data: otp_reset,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function() {
            // $('#button-resend-otp').button('loading');
        },
        success: function(msg)
        {
            data = JSON.parse(msg);
            
            if(data.Success == "Success")
            {
                return false;
            }
            else if(data.Success == "fail") 
            {
                // alert(data.resp);
                return false;
            }	
        },
        error: function (request, status, error)
        {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);	
        },
        complete: function()
        {
            $('#button-resend-otp').button('reset');	
        }	
    });
}

$('#frm_registration').on('submit', function(e) 
{
    e.preventDefault();
    register_user();
});

$('#frm_login').on('submit', function(e) 
{
    e.preventDefault();
    getLogin();
});

$('#frm_user_profile').on('submit', function(e) 
{
    e.preventDefault();
    updateUserProfile();
});

function register_user()
{
    let user_first_name = $('#user_first_name').val();
    let user_last_name  = $('#user_last_name').val();
    let user_mobile     = $('#reg_mobile_num').val();
    let input_otp       = $('#input-otp').val();

    var sendInfo     = {"user_first_name":user_first_name, "user_last_name":user_last_name, "user_mobile":user_mobile, "input_otp":input_otp, "register_user":1};
    var registerUser = JSON.stringify(sendInfo);
    
    $.ajax({
        type: "POST",
        url: "controller/load_custom.php",
        data: registerUser,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function() {
            // $('#button-resend-otp').button('loading');
        },
        success: function(msg)
        {
            data = JSON.parse(msg);
            
            if(data.Success == "Success")
            {
                console.log(data.resp);
                window.location.replace("http://localhost/rbv-init/dashboard.php");
                return false;
            }
            else if(data.Success == "fail") 
            {
                alert(data.resp);
                return false;
            }	
        },
        error: function (request, status, error)
        {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);	
        },
        complete: function()
        {
            $('#button-resend-otp').button('reset');	
        }	
    });
}

function getLogin()
{
    let user_mobile   = $('#login_mobile_num').val();
    let user_password = $('#login_password').val();

    res = onlyNumbers(user_mobile);

    if(res)
    {
        var sendInfo  = {"user_mobile":user_mobile, "user_password":user_password, "user_login":1};
        var loginUser = JSON.stringify(sendInfo);

        $.ajax({
            type       : "POST",
            url        : "controller/load_custom.php",
            data       : loginUser,
            processData: false,
            contentType: false,
            cache      : false,
            success    : function(msg)
            {
                data = JSON.parse(msg);
                
                if(data.Success == "Success")
                {
                    console.log(data.resp);
                    window.location.replace("http://localhost/rbv-init/dashboard.php");
                    return false;
                }
                else if(data.Success == "fail") 
                {
                    alert(data.resp);
                    return false;
                }	
            },
            error: function (request, status, error)
            {
                return false;
                // alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);	
            },
            complete: function()
            {
                return false;
                // $('#button-resend-otp').button('reset');	
            }	
        });
    }
    else
    {
        $('#login_mobile_num').val('');
        return false;
    }
}

function updateUserProfile()
{
    let user_id     = $('#hid_user_id').val();
    let user_email  = $('#user_email').val();
    let user_grade  = $('#ddl_grade_list').val();
    let user_school = $('#user_school').val();

    if(user_email != '')
    {
        var sendInfo     = {"user_id":user_id, "user_email":user_email, "user_grade":user_grade, "user_school":user_school, "updateUserProfile":1};
        var updateUserProfile = JSON.stringify(sendInfo);
        
        $.ajax({
            type: "POST",
            url: "controller/load_custom.php",
            data: updateUserProfile,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                // $('#button-resend-otp').button('loading');
            },
            success: function(msg)
            {
                data = JSON.parse(msg);
                
                if(data.Success == "Success")
                {
                    $('#section_user_profile').hide();
                    $('#section_services').show();
                    return false;
                }
                else if(data.Success == "fail") 
                {
                    alert(data.resp);
                    return false;
                }	
            },
            error: function (request, status, error)
            {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);	
            },
            complete: function()
            {
                $('#button-resend-otp').button('reset');	
            }	
        });
    }
    else
    {
        alert('Please enter an Email-ID!');
        return false;
    }
}

function blockSpecialChar(e)
{
    var k;
    document.all ? k = e.keyCode : k = e.which;
    // console.log(k);
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || (k < 48 && k > 57));
}

function numbersOnly(e)
{
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k >= 48 && k <= 57));
}

function getParticipate(user_id, user_client_token, client_id, micro_website_link, client_api_link)
{
    // from here we will call the API for respective client [i.e. client_api_link]
    // Consider for now, resp = true, then what will happen in our end

    resp = true;

    if(resp)
    {
        // store this data at our end and on success, redirect to respective micro_site
        var sendInfo  = {"user_id":user_id, "user_client_token":user_client_token, "client_id":client_id, "store_user_client_token":1};
        var loginUser = JSON.stringify(sendInfo);

        $.ajax({
            type       : "POST",
            url        : "controller/load_custom.php",
            data       : loginUser,
            processData: false,
            contentType: false,
            cache      : false,
            success    : function(msg)
            {
                data = JSON.parse(msg);
                
                if(data.Success == "Success")
                {
                    window.location.replace(micro_website_link);
                    return false;
                }
                else if(data.Success == "fail") 
                {
                    alert(data.resp);
                    return false;
                }	
            },
            error: function (request, status, error)
            {
                return false;
                // alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);	
            },
            complete: function()
            {
                return false;
                // $('#button-resend-otp').button('reset');	
            }	
        });
    }
    else
    {
        // pending [have to discuss with Punit sir]
    }
}