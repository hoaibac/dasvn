<?php

class svnAdmin {
	
	private $htpasswdBin;
	private $passwdFile;
	private $svnDirectory;
	private $domain;
	public $authz = array();
	public $htpasswd;
	
    public function __construct() {	
    	
    	
    	if(isset($_REQUEST['domain'])) {
    		$this->domain = $_REQUEST['domain'];
    	}
    	
		$this->htpasswdBin = "/usr/bin/htpasswd";
		$this->passwdFile = getenv('HOME') . "/svn_settings/passwd";
		$this->svnDirectory = getenv('HOME') . "/domains/".$this->domain."/svn_repositories";

		
    	$dir=opendir(getenv('HOME').'/domains');
    	while( ($curr=readdir($dir))) {
			if($curr != '.' && $curr != '..') {
				$this->authz[$curr] = new mod_authz_svn(getenv('HOME') . "/domains/".$curr."/svn_settings/authz");
			}
    	}
		
		$this->htpasswd = new htpasswd($this->passwdFile);
    }
    
    public function getSVNRepoDirectory() {
    	return $this->svnDirectory;
    }
    

    
}


?>