<?php
	
	include('_classes/class.svnAdmin.php');
	include('_classes/class.mod_authz_svn.php');
	include('_classes/class.htpasswd.php');
	
	include('_classes/class.alias.php');
	include('_classes/class.group.php');
	include('_classes/class.repo.php');
	include('_classes/class.user.php');

    $domain = '';
    
    if(isset($_REQUEST['domain'])) {
    	$domain = $_REQUEST['domain'];
    }
    	
    	
	$svnAdmin = new svnAdmin();

	if(isset($_REQUEST['cancel']) && $_REQUEST['cancel'] == "Cancel") {
		$_REQUEST['username'] = '';
		$_REQUEST['newPassword1'] = '';
		$_REQUEST['newPassword2'] = '';
		$_REQUEST['password1'] = '';
		$_REQUEST['password2'] = '';
		$_REQUEST['action'] = '';
	}
	
	
	function recursive_remove_directory($directory, $empty=FALSE)
	{
	     if(substr($directory,-1) == '/')
	         $directory = substr($directory,0,-1);
	         
	     if(!file_exists($directory) || !is_dir($directory)) {
	         return FALSE;
	     }
	     elseif(!is_readable($directory)) {
	         return FALSE;
	     }
	     else {
	         $handle = opendir($directory);
	
	         while (FALSE !== ($item = readdir($handle)))
	         {
	             if($item != '.' && $item != '..')
	             {
	                 $path = $directory.'/'.$item;
	                 if(is_dir($path))
	                     recursive_remove_directory($path);
	                 else
	                     unlink($path);
	             }
	         }
	         closedir($handle);
	         if($empty == FALSE)
	         {
	             if(!rmdir($directory))
	                 return FALSE;
	         }
	         return TRUE;
	     }
	}

	
?>