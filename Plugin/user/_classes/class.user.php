<?php

class user {
    
    // The deliminator used in the passwd file
	private $username;   
	private $read;
	private $write;
    function __construct($username, $read = false, $write = false) {
		$this->username = $username;
		$this->read = $read;
		$this->write = $write;
    }
    
    public function getUsername() {
    	return $this->username;
    }
    
    public function getPermissions() {
    	$permissions = '';
    	if($this->read) $permissions .= 'r';
    	if($this->write) $permissions .= 'w';
    	return $permissions;
    }
    
	public function hasReadPermissions() {
    	return $this->read;
    }
    public function hasWritePermissions() {
    	return $this->write;
    }
}
        
?>