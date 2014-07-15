<?php
/*
* class LoginModel to handle login related data operations 
* @author: Jeetendra A Gawas
* @version: 1.0.0
* @since: 24th july 2012 	
*/
class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		//$this->config->load('dbtables', TRUE);
	}
	
	// save (insert/update) record
	function save($recordObj)
	{			
		$saveFlag = FALSE;
		
		//Create common data array 
		$data = array( // field => value pair - other than primary key
				   'first_name' => $recordObj->getFirstName(),
				   'last_name' => $recordObj->getLastName(),
				   'mobile_number' => $recordObj->getMobileNumber(),
				   'email' => $recordObj->getEmail(),
				   'other_contact_number' => $recordObj->getOtherContactNumber(),
				   'area' => $recordObj->getArea(),
				   'user_code' => $recordObj->getUserCode()

				);
		
		// Check operation type based on Id					
		if ($recordObj->getId() == NULL){ // Add operation

			$saveFlag = $this->db->insert("user", $data);		

			// Now, compute user_code and update this field in database
			//Based on unique-id, user's first name, last name and mobile number, compute user-code using below given format
			//unique-id, 2 letters from firstname and lastname, last 4 digits of mobile number 
			
                        
                        //issue of mobile no not getting saved correctly is due to its type int, changed to BigInt
			if ($saveFlag){
			
				//Get last inserted ID
				$id = mysql_insert_id();
				$fn = substr($recordObj->getFirstName(), 0, 2); // first two characters 
				$ln = substr($recordObj->getLastName(), 0, 2); // first two characters
				$mobile = substr($recordObj->getMobileNumber(), -4, 4);  // last four digit so go back from -1 which is -4
			
				$userCode = $id.$fn.$ln.$mobile;
			
				//Update userCode using last id			
				$this->updateUserCode($userCode, $id);	
                                
                                $recordObj->setId($id);
                                $recordObj->setUserCode($userCode);     //set usercode to user obj for sending email
			} 
                        
		}
				
		return $saveFlag;
	
	}		
	
	// Updates userCode
	function updateUserCode($userCode, $id)
	{			
		
		//Create common data array 
		$data = array( // field => value pair - other than primary key
				   'user_code' => $userCode
				);
						
		$this->db->where('id', $id);
		$queryResult = $this->db->update("user", $data);	
				
		return $queryResult;
	
	}
}
	