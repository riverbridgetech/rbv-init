<?php
    function generateRandomString($length, $type)
    {
		$characters = '';
		if($type == 'user_password')
		{
			$characters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
		}
		elseif($type == 'mobile_verification')
		{
			$characters = '123456789';
		}
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    function sendMessage($mob,$data_msg)
	{
		
		$data_msg = str_replace("<p>","",$data_msg);
		$data_msg = str_replace("</p>","",$data_msg);
		$data = '<?xml version="1.0" encoding="UTF-8"?>';
		$data .=<<<EOF
<xmlapi>
<auth>
<apikey>Aa5bb88a11334f34fb782e96267b4e268</apikey>
</auth>
<sendSMS>
<to></to>
<text></text>
<msgid>0</msgid>
<sender>MYSTDY</sender>
</sendSMS>
<response>Y</response>
</xmlapi>
EOF;
		 if (preg_match("/^\d{10}$/",$mob)) 
		 {
			//$count_sms++;
			$data = str_replace("<to></to>","<to>".$mob."</to>",$data);
			$data = str_replace("<text></text>","<text>".$data_msg."</text>",$data);
			//print sprintf("%04d",$count_sms)." => ".$mobile_num." => ".$data."<br/><hr/>";
	
			$url = "http://alerts.sinfini.com/api/xmlapi.php?data=".urlencode($data);
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output=curl_exec($ch);
			curl_close($ch);
			//return $output;
		 }
		return true;
	}
?>