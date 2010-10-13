<?php

class repo {
    
    // The deliminator used in the passwd file
    private $location;
    private $name;
    public $users = array();
   
    function __construct($name, $location) {
		$this->name = $name;
		$this->location = $location;
    }
    
    public function getName() {
    	return $this->name;
    }
    
    public function getLocation() {
    	return $this->location;
    }
    
    public function addUser($user) {
    	$this->users[] = $user;
    }
    public function deleteUser($username) {
    	$deleted = false;
    	$newUsers = array();
    	
    	foreach($this->users as $user) {
    		if($user->getUsername() == $username){
    			$deleted = true;
    		}
    		else {
    			$newUsers[] = $user;
    		}
    	}
    	$this->users = $newUsers;
    	return $deleted;
    }
    public function getUsers() {
    	return $this->users;
    }
    
}
        
?>