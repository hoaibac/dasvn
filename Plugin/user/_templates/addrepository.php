<?php 
	include('_includes/functions.php');
	include('_templates/header.php');
?>

<b>SVN Manager - Add repository</b>
	<br>
	<br>
<?php 



	$repositoryName = '';
	
	//print "This is still under development.";
	$allowed = true;
	if(isset($_POST['repositoryName']) && strlen($_POST['repositoryName']) > 0 && $allowed) {
		$repositoryName = strtolower($_POST['repositoryName']);
		$users = array();
		
		$pattern = "/^([a-z0-9_])+$/";
		if(!preg_match($pattern,$repositoryName)) {
			echo 'Repository name contains invalid characters!';
			$repositoryName = '';
		}
		else if (strlen($repositoryName) <= 1) {
			print "Name is to short";
		}
		else if (strlen($repositoryName) > 15) {
			print "Name is to long";
		}
		else if ($svnAdmin->authz[$domain]->checkRepo($repositoryName)) {
			print "Repository already exists";
		}
		else {
			echo 'Repository added successfully!';
			foreach($_POST['username'] as $username) {
				$permissions = '';
				$read  = hasReadAccess($username);
				$write  = hasWriteAccess($username);
				if($read || $write) {
					$users[] = new user($username, $read, $write);
				}
			}
			$svnAdmin->authz[$domain]->addRepo($repositoryName, $users);
			
			$pathname = $svnAdmin->getSVNRepoDirectory() . '/' . $repositoryName;
			
			$phpmd5file = md5(time().'myHash').'.php';
			
			$public_html = getenv('HOME') . "/domains/".$domain."/public_html/". $phpmd5file;
			$http_html = 'http://'.$domain.'/'.$phpmd5file;
			//print "<br />repo to create is: " . $pathname;
			//print "<br />==============================<br />";
			$cmd = '/usr/bin/svnadmin create ' . $pathname . ' 2>&1';
			//print "<br /> running: " . $cmd;
			//exec($cmd, $out, $err); print $out."<br />\n<br />\n". $err;
			
			$php = '<?PHP'."\n".
					'exec("'.$cmd.'", $out, $err);'."\n".
					'print_r($out);'."\n".
					'print "<br />";'."\n".
					'print_r($err);'."\n".
					'print "<br />";'."\n".
					'?>';
			file_put_contents($public_html, $php);
			$result = file_get_contents($http_html);
			unlink($public_html);
			
			//echo "<br />return value: $err<br />\n";
			//echo "output:<br />" . implode("<br />\n", $out); 
			
			
			//$cmd = '/bin/chmod 777 ' . $pathname . ' -R 2>&1';
			//print "<br /> running: " . $cmd;
			
			//exec($cmd, $out, $err);
			//echo "<br />return value: $err<br />\n";
			//echo "output:<br />" . implode("<br />\n", $out); 
			
			
			/*
		
			print "<br />==============================<br />";
			
			
			$cmd = '/usr/bin/whoami 2>&1';
			print "<br /> running: " . $cmd;
			
			exec($cmd, $out, $err);
			echo "<br />return value: $err<br />\n";
			echo "output:<br />" . implode("<br />\n", $out); 
			
			print "<br />==============================<br />";
			
			
			
			$cmd = '/bin/ls -l ' .$svnAdmin->getSVNRepoDirectory() . '  2>&1';
			print "<br /> running: " . $cmd;
			$err = '';
			$out = '';
			exec($cmd, $out, $err);
			echo "<br />return value: $err<br />\n";
			echo "output:<br />" . implode("<br />\n", $out); 
			
			print "<br />==============================<br />";
			
			
			$cmd = '/bin/chown -R ' . getenv('USERNAME') . ':apache ' .$pathname . '  2>&1';
			print "<br /> running: " . $cmd;
			$err = '';
			$out = '';
			exec($cmd, $out, $err);
			echo "<br />return value: $err<br />\n";
			echo "output:<br />" . implode("<br />\n", $out); 
			
			print "<br />==============================<br />";			
			*/
			
			$repositoryName = '';
			$_POST['read'] = array();
			$_POST['write'] = array();
		}
	}

	function hasReadAccess($username) {
	
		if(isset($_POST['read']) && is_array($_POST['read'])) {
			return in_array($username, $_POST['read']);
		}
		return false;
	}

	function hasWriteAccess($username) {
		if(isset($_POST['write']) && is_array($_POST['write'])) {
			return in_array($username, $_POST['write']);
		}
		return false;
	}

?>
	<?php include('_templates/menu.php'); ?>
	<form name="info" action="" method="post">
	<input type="hidden" name="page" value="addrepository">
	<table class=list cellpadding=3 cellspacing=1>

		<tr><td class=listtitle colspan=2>Create Repository</td></tr>

		<tr><td class=list>Name:</td><td class=list><input type=text name="repositoryName" value="<?= $repositoryName ?>" size=20></td></tr>


	</table>
	
	
	<table class=list cellpadding=3 cellspacing=1>

		<tr><td class=listtitle>User access</td><td class=listtitle>Read</td><td class=listtitle>Write</td></tr>

		<?php 
		
		$users = $svnAdmin->htpasswd->getUsers();
		
		if(count($users) == 0) {
			print '<tr>
				<td class="list" coolspan="3">No users found</td>
			</tr>';
		}
		for ($i = 0; $i < count($users) ; $i++) {
			if($i % 2) {
				$cssClass = 'list';
			}
			else {
				$cssClass = 'list2';
			}
			$read = '';
			$write = '';
			if(hasReadAccess($users[$i])) {
				$read = 'checked="checked"';
			}
			if(hasWriteAccess($users[$i])) {
				$write = 'checked="checked"';
			}
			print '<tr>
				<td class="'.$cssClass.'">'.$users[$i].'<input type="hidden" name="username[]" value="'.$users[$i].'"></td>
				<td class="'.$cssClass.'"><input type="checkbox" name="read[]" value="'.$users[$i].'" '.$read.'></td>
				<td class="'.$cssClass.'"><input type="checkbox" name="write[]" value="'.$users[$i].'" '.$write.'></td>
			</tr>';
		}
		?>

		<tr><td class=listtitle colspan=3 align=right>
			<input type=submit name=create value="Create">
		</td></tr>

	</table>
</form>
<?php 


	include('_templates/footer.php');
?>