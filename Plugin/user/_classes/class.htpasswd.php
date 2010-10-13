<?php

class htpasswd {
    
    
    var $passwdFile;
    
    
    // The deliminator used in the passwd file
    var $deliminator = ':';
    
   
    public function __construct($passwdFile) {
		$this->passwdFile = $passwdFile;
		

		
    }
    
    /*
     * Returns true if the given user is found in the passwd file. False otherwise.
     */
    public function checkUser($user) {
        $lines = $this->_getUsersArray();
        foreach($lines as $line) {
            if($this->_retrieveUsername($line) == $user) {
                return true;
            }
        }
        return false;
    }
    
    /*
     * Removes the given user from the passwd file. If the user was removed succesfully,
     * true is returned, false otherwise (e.g.: if the user was not in the file, false
     * is returned.
     */
    public function deleteUser($user) {
        $lines = $this->_getUsersArray();
        $usersArr = array();
        $result = false;
        foreach($lines as $line) {
            if($this->_retrieveUsername($line) != $user) {
                $usersArr[] = $line;
            } else {
                $result = true;
            }
        }
        $this->_saveUsersArray($usersArr);
        return $result;
    }
    
    /*
     * Adds the given user to the passwd file. If the user was added succesfully,
     * true is returned, false otherwise (e.g.: if the user was already in the file, false
     * is returned.
     */
    public function addUser($user, $password) {
        if(!$this->checkUser($user)) {
            $usersArr = $this->_getUsersArray();
            $usersArr[] = $user . $this->deliminator . $this->crypt_apr1_md5($password);
            $this->_saveUsersArray($usersArr);    
            return true;
        }
        return false;
    }
    
    /*
     * Changes the password of the given user. If the password was changes succesfully,
     * true is returned, false otherwise (e.g.: if the user was not in the file, false
     * is returned.
     */
    public function changePassword($user, $newPassword) {
        $lines = $this->_getUsersArray();
        $usersArr = array();
        $changed = false;
        foreach($lines as $line) {
            if($this->_retrieveUsername($line) != $user) {
                $usersArr[] = $line;
            } else {
                $usersArr[] = $user . $this->deliminator . $this->crypt_apr1_md5($newPassword);
                $changed = true;
            }
        }
        if($changed) {
            $this->_saveUsersArray($usersArr);
        }
        return $changed;
    }
    
    public function getUsers() {
        $lines = $this->_getUsersArray();
        $users = array();
        foreach($lines as $line) {
            $users[] = $this->_retrieveUsername($line);
        }
        return $users;
    }
    
    /*
     * PRIVATE FUNCTIONS
     */
    
    /*
     * crypt password apaches way
     */
	private function crypt_apr1_md5($plainpasswd) {
	    $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
	    $len = strlen($plainpasswd);
	    $text = $plainpasswd.'$apr1$'.$salt;
	    $bin = pack("H32", md5($plainpasswd.$salt.$plainpasswd));
	    for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
	    for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $plainpasswd{0}; }
	    $bin = pack("H32", md5($text));
	    for($i = 0; $i < 1000; $i++) {
	        $new = ($i & 1) ? $plainpasswd : $bin;
	        if ($i % 3) $new .= $salt;
	        if ($i % 7) $new .= $plainpasswd;
	        $new .= ($i & 1) ? $bin : $plainpasswd;
	        $bin = pack("H32", md5($new));
	    }
	    $tmp = '';
	    for ($i = 0; $i < 5; $i++) {
	        $k = $i + 6;
	        $j = $i + 12;
	        if ($j == 16) $j = 5;
	        $tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
	    }
	    $tmp = chr(0).chr(0).$bin[11].$tmp;
	    $tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
	    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
	    "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
	    return "$"."apr1"."$".$salt."$".$tmp;
	}
    
    
    private function _getUsersArray() {
        //$filename = $this->passwdFile;
        //$fp = fopen($filename, 'r');
        //$file_contents = fread($fp, filesize($filename));
        //fclose($fp);
        $file_contents = file_get_contents($this->passwdFile);
        
        //var_dump(trim($file_contents));
        $file_content_lines = explode ("\n", trim($file_contents));
        $lines = array();
        foreach($file_content_lines as $line) {
        	if(trim($line) != "") $lines[] = $line;
        }
        return $lines;
    }
    
    private function _saveUsersArray(&$arr) {
        $file_contents = implode("\n", $arr);
        file_put_contents($this->passwdFile, $file_contents);
        //$filename = $this->passwdFile;
        //$fp = fopen($filename, 'w');
        //fwrite ($fp, trim($file_contents));
        //fclose($fp);
    }
    
    private function _retrieveUsername($line) {
        return substr($line, 0, strrpos($line, $this->deliminator));
    }
    
    private function _retrievePassword($line) {
        return substr($line, strrpos($line, $this->deliminator) + 1);
    }
}
        
?>