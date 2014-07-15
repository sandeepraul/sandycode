<?php
/*
* class User_obj represents user object in datbase
* @author: Jeetendra A Gawas
* @version: 1.0.0
* @since: 24th july 2012 	
*/
class User_obj {

	var $id;
	var $firstName;
	var $lastName;
	var $mobileNumber;
	var $email;
	var $otherContactNumber;
	var $area;
	var $userCode;
	
	function __construct(){
	}

	function setId($id){
		$this->id = $id;		
	}
	function getId(){
		return $this->id;		
	}
	
	function setFirstName($firstName){
		$this->firstName = $firstName;		
	}
	
	function getFirstName(){
		return $this->firstName;		
	}
	
	function setLastName($lastName){
		$this->lastName = $lastName;		
	}
	
	function getLastName(){
		return $this->lastName;
	}
	
	function setMobileNumber($mobileNumber){
		$this->mobileNumber = $mobileNumber;		
	}
	
	function getMobileNumber(){
		return $this->mobileNumber;		
	}
	
	function setEmail($email){
		$this->email = $email;		
	}
	
	function getEmail(){
		return $this->email;		
	}

	function setOtherContactNumber($otherContactNumber){
		$this->otherContactNumber = $otherContactNumber;		
	}
	
	function getOtherContactNumber(){
		return $this->otherContactNumber;		
	}
	
	function setArea($area){
		$this->area = $area;		
	}
	
	function getArea(){
		return $this->area;		
	}
	
	function setUserCode($userCode){
		$this->userCode = $userCode;		
	}
	
	function getUserCode(){
		return $this->userCode;		
	}

}
