<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() //default constructor
    {
        parent::__construct(); //call to default constructor of CI_Controller
		$this->load->helper('url');		
		$this->load->library('common_obj'); //user defined class					
		$this->load->library('user_obj'); 		
		$this->load->model('user_model'); 
    }
	
	public function index()
	{
		$this->load->view('register');
	}
	
	
 	function save()
	{
		// Create user object
		$recordObj = new $this->user_obj;			
		$recordObj->setId(NULL); // For add operation, id is autoincremented		
		$recordObj->setFirstName($this->input->post('firstName'));
		$recordObj->setLastName($this->input->post('lastName'));
		$recordObj->setMobileNumber($this->input->post('mobileNumber'));
		$recordObj->setEmail($this->input->post('email'));
		$recordObj->setOtherContactNumber($this->input->post('otherContactNumber'));
		$recordObj->setArea($this->input->post('area'));
		$recordObj->setUserCode(""); //default empty, this will be updated after insert query in user_model - save()
		
		// Call model function to add/edit record
		$saveFlag = $this->user_model->save($recordObj);
                
		if ($saveFlag){
                    
                    //check whether email is provided by user or not
                    $is_email_present = $recordObj->getEmail();
                    
                    // if email present then send email
                    if(!empty($is_email_present))
                    {
                        //email to member
                        $user_mail_append = "ThankYou for Registration. <br/><br/>Your Registration details are: <br/>" ;      //only for member who has registered.
                        $is_admin = false;

                        $this->common_obj->sendEmail($recordObj,$user_mail_append ,$is_admin);
                       
                    }
                    
					//Display registraton details on thank you page
                    $data['recordObj'] = $recordObj;
                    
                    
                    //email to admin
                    $admin_mail_append = "Following member is registered: <br>";
                    $is_admin = true;

                    $this->common_obj->sendEmail($recordObj,$admin_mail_append ,$is_admin);
                    
                    
                    //show thank you page and then send email
                    $this->load->view('thankyou',$data);
		}
		else{
			$this->load->view('register');
		}
		
	}
       
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */