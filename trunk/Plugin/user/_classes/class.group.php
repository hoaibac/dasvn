<?php

class group {
    
    var $name;
    var $users;
    
    function __construct($name, $users) {
		$this->name = $name;
		$this->users = $users;
    }
    
	public function getName() {
    	return $this->name;
    }
	public function getUsers() {
    	return $this->users;
    }
    
}
        
?>