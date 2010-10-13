<?php

class alias {
    
    private $name;
    private $alias;
    
    function __construct($name, $alias) {
		$this->name = $name;
		$this->alias = $alias;
    }
    
    public function getName() {
    	return $this->name;
    }
    public function getAlias() {
    	return $this->alias;
    }
    
}
        
?>