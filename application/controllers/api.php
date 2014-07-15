<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() //default constructor
    {
        parent::__construct(); //call to default constructor of CI_Controller
		$this->load->helper('url');
                $this->load->helper('email');
		$this->load->library('session');
		$this->load->library('services_json');		
		$this->load->library('common_obj'); //user defined class					
		$this->load->library('user_obj'); 				
		//Define array that will store values to be sent to view page
		$passArg = array();	    		
    }
	
	public function index()
	{
		//$this->load->view('welcome_message');
		echo "testing..";
	}
	
	/**
	
	This API is used to register user
	Input parameters: firstName, lastName, mobileNumber, email, otherContactNumber, area
	
	*/
	
 	function register()
	{	
		//instantiate JSON obj
		$json = new $this->services_json;
		$commonObj = new $this->common_obj;
		
		//retrive headers sent from iphone device
		$headers = $commonObj->getFormattedHeaders();
			
                
		if(empty($headers['firstName'])) {
			echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'Please enter First Name')));
			exit;
		}
                else if(!ctype_alpha($headers['firstName']))
                {
                        echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'First Name must contain only alphabets.')));
			exit;
                }
                else{
			$firstName = trim($headers['firstName']);
		}

                
		if(empty($headers['lastName'])) {
			echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'Please enter Last Name')));
			exit;
		}
                else if(!ctype_alpha($headers['lastName']))
                {
                        echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'Last Name must contain only alphabets.')));
			exit;
                }
                else{
			$lastName = trim($headers['lastName']);
		}
		
                
		if(empty($headers['mobileNumber'])) {
			echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'Please enter Mobile Number')));
			exit;
		}
                else if(!ctype_digit($headers['mobileNumber']))
                {
                        echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'Mobile Number must be numeric.')));
			exit;
                }
                else if(strlen($headers['mobileNumber']) != 10)
                {
                        echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'Mobile Number must be of length 10.')));
			exit;
                }
                else{
			$mobileNumber = trim($headers['mobileNumber']);
		}

                $email = "";
                //(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == FALSE)   //in built php function to check valid email   
		if(!empty($headers['email'])) 
                {
                    if(!valid_email($headers['email']))        //method used from email helper to validate email
                    {
                            echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'Please enter valid email id.')));
                            exit;
                    }
                    else{
                            $email = trim($headers['email']);
                    }
                }
                
		//read other optional parameters
		$otherContactNumber = "";
		if (!empty($headers['otherContactNumber'])){
                    if(!ctype_digit($headers['otherContactNumber']))
                    {
                            echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'Mobile Number must be numeric.')));
                            exit;
                    }
                    else if(strlen($headers['otherContactNumber']) != 10)
                    {
                            echo $json->encode(array("register" => array("Response Code"=>"1","Message" => 'Mobile Number must be of length 10.')));
                            exit;
                    }
                    else{
                            $otherContactNumber = trim($headers['otherContactNumber']);
                    }
                }
		
		$area = "";
		if (!empty($headers['area'])){
			$area = trim($headers['area']);		
		}

		//Based on unique-id, user's first name, last name and mobile number, compute user-code using below given format
		//unique-id, 2 letters from firstname and lastname, last 4 digits of mobile number 
			
		$this->load->model('user_model'); 
		
		//Create user obj and set email and password parameters
		$userObj = new $this->user_obj;		
		$userObj->setId(NULL); //auto-increment
		$userObj->setFirstName($firstName);
		$userObj->setLastName($lastName);
		$userObj->setMobileNumber($mobileNumber);
		$userObj->setEmail($email); // Must be unique
		$userObj->setOtherContactNumber($otherContactNumber);
		$userObj->setArea($area);
		$userObj->setUserCode("");
		
		//check for valid user in database.
		$saveFlag = $this->user_model->save($userObj);	

 		if($saveFlag == TRUE)
		{ 		
                    
                    //check whether email is provided by user or not
                    $is_email_present = $userObj->getEmail();
                    
                    // if email present then send email
                    if(!empty($is_email_present))
                    {
                        //email to member
                        $user_mail_append = "ThankYou for Registration. <br/><br/>Your Registration details are: <br/>" ;      //only for member who has registered.
                        $is_admin = false;

                        $this->common_obj->sendEmail($userObj,$user_mail_append ,$is_admin);
                       
                    }
                    else {  //else display registraton details on thank you page
                        $data['recordObj'] = $userObj;
                    }
                    
                    //email to admin
                    $admin_mail_append = "Following member is registered: <br>";
                    $is_admin = true;

                    $this->common_obj->sendEmail($userObj,$admin_mail_append ,$is_admin);
                        
                    //Send UserDetails array to iphone device
                    echo str_replace('\\/', '/',$json->encode(array("register" =>array("Response Code"=>'0','msg' => "Registered successfully" ,'respData' => $data))));
                    exit;	
		
		}else
		{ 
			echo json_encode(array("register" =>array("Response Code"=>'1','Message'=>"Registeration failed")));
			exit;	
		} 
	}		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */