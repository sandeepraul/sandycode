<?php

// This class will hold all commonly used functions across the application
class Common_obj {
	
	function __construct(){				

	}
	
	function test(){
		return "test";
	}
	

	//getFormattedHeaders to get headers in prefromatted format.
	function getFormattedHeaders(){
		
		//get headers variable
		$headers = array();
		if(!function_exists('apache_request_headers')) {
			function apache_request_headers() {
				foreach($_SERVER as $key => $value) {
					if(substr($key, 0, 5) == 'HTTP_') {
						$headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
					}
				}
				return $headers;
			}
		}
		else{
			$headers = apache_request_headers();
		}

		$headers = apache_request_headers();
		foreach($headers as $key => $value) 
		{					
		   $headers[str_replace('-', '_', strtolower($key))] = $value;			
		}		
		return $headers;	
	}

	
	/**
	 * function generateEmailMatter for Home controller to check unique email id 
	 * 
	 * @param String argArray array of arguements passed to teh function
	 * @return Array emailArgs with list of emial paramters emailid, messagebody,subject 
	 * */
	function generateEmailMatter($argArray)
	{
		$CI =& get_instance();
		
		$passEmailArgs=array();		
			
		$fromName=$CI->config->item('fromName');
		$fromEmail=$CI->config->item('fromEmail');
		//echo $argArray['emailType'];
		switch($argArray['emailType']){
		
			case 'SEND_MESSAGE_TO_USER':
				$viewArr['to'] 	= $fromName;
				$viewArr['toName']= $argArray['toName'];
				$viewArr['message'] 	= $argArray['message'];
				$message=$CI->load->view('emails/emailTemplate',$viewArr,true);
				$CI->load->library('email');
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$CI->email->initialize($config);
				$CI->email->from($fromName);
				$CI->email->to($fromEmail);
				//$CI->email->cc('another@another-example.com');
				//$CI->email->bcc('them@their-example.com');
				$CI->email->subject($argArray['subject']);
				$CI->email->message($message);
				$CI->email->send();
				
			break;
			
			case 'SEND_REG_APP_MAIL':
				
				$viewArr['to'] 	= $fromName;
				$viewArr['toName']= $argArray['toName'];
				$viewArr['message'] 	= $argArray['message'];
				$message=$CI->load->view('emails/emailTemplate',$viewArr,true);
				$CI->load->library('email');
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$CI->email->initialize($config);
				$CI->email->from($fromName);
				$CI->email->to($fromEmail);
				//$CI->email->cc('another@another-example.com');
				//$CI->email->bcc('them@their-example.com');
				$CI->email->subject($argArray['subject']);
				$CI->email->message($message);
				$CI->email->send();
			break;
		
			
			default:
			break;
		} 
		
	    return $passEmailArgs;
	}
	
        function sendEmail($recordObj,$append_message,$is_admin)
        {
            $CI =& get_instance();
           
            $email_smtp_settings = $CI->config->item('settings');
            
            $CI->load->library('email', $email_smtp_settings);

            $CI->email->set_newline("\r\n");
            
            $CI->email->clear(TRUE);

            $CI->email->from(SMTP_USER, FROM_NAME);
            
            $CI->email->subject('Karma - Member Registration');
            
            // message
            $message = '
            <BR> Member Code: '.$recordObj->getUserCode().'
            <BR> First Name: '.$recordObj->getFirstName().'
            <BR> Last Name: '.$recordObj->getLastName().'
            <BR> Mobile Number: '.$recordObj->getMobileNumber().'
            <BR> Email: '.$recordObj->getEmail().'
            <BR> Other Contact Number: '.$recordObj->getOtherContactNumber().'
            <BR> Area: '.$recordObj->getArea().'

            <BR><BR><BR> Thanks,
            <BR> Karma Team';
           
            if($is_admin)
            {
                //send email to admin
                $admin_to = ADMIN_EMAIL; // 'milesh.bothara@quagnitia.com';	
                $CI->email->to($admin_to);
            }
            else
            {
                //send email to member
                $member_to = $recordObj->getEmail();        //member email address
                $CI->email->to($member_to);
            }
            
            $CI->email->message($append_message.$message);
            $sent = $CI->email->send();
            
            
            if($sent)     //if mail sent return true
            {
                return true;
            }
            else //else false
            {
                return false;
            }
        }
}
