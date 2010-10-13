<?php 
	include('_includes/functions.php');
	include('_templates/header.php');
?>

<b>SVN Manager - Change permissions</b>
	<br>
	<br>
<?php 
	$repository = false;
	if(isset($_REQUEST['repository']) && strlen($_REQUEST['repository']) > 0 && isset($svnAdmin->authz[$domain])) {
		$repository = $svnAdmin->authz[$domain]->getRepo($_REQUEST['repository']);
		
		
		
		if(isset($_POST['change']) && strlen($_POST['change']) > 0) {
			if ($repository == false) {
				print "Repository doesn't exists";
			}
			else {
				echo 'Repository added successfully!';
				$users = array();
				foreach($_POST['username'] as $username) {
					$permissions = '';
					$read  = hasReadAccess($username);
					$write  = hasWriteAccess($username);
					if($read || $write) {
						$users[] = new user($username, $read, $write);
					}
				}
				$svnAdmin->authz[$domain]->changeRepo($repository, $users);

			}
		}
	}

	function hadReadAccess($username, $repository) {
		if($repository == false) return false;
		$users = $repository->getUsers();

		foreach($users as $user) {
			if($user->getUsername() == $username && $user->hasReadPermissions()) {
				return true;
			}
		}
		return false;
	}
	function hadWriteAccess($username, $repository) {
		if($repository == false) return false;
		$users = $repository->getUsers();

		foreach($users as $user) {
			if($user->getUsername() == $username && $user->hasWritePermissions()) {
				return true;
			}
		}
		return false;
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
	<input type="hidden" name="page" value="changepermissions">
	<input type="hidden" name="change" value="<?= $repository->getName() ?>">
	<table class=list cellpadding=3 cellspacing=1>

		<tr><td class=listtitle colspan=2>Create Repository</td></tr>

		<tr><td class=list>Name:</td><td class=list><input type=text name="oldRepositoryName" disabled="disabled" value="<?= $repository->getName() ?>" size=20></td></tr>


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
			
			if(isset($_POST['change']) && strlen($_POST['change']) > 0) {
				if(hasReadAccess($users[$i])) {
					$read = 'checked="checked"';
				}
				if(hasWriteAccess($users[$i])) {
					$write = 'checked="checked"';
				}
			}
			else {
				if(hadReadAccess($users[$i], $repository)) {
					$read = 'checked="checked"';
				}
				if(hadWriteAccess($users[$i], $repository)) {
					$write = 'checked="checked"';
				}
			}
			
			print '<tr>
				<td class="'.$cssClass.'">'.$users[$i].'<input type="hidden" name="username[]" value="'.$users[$i].'"></td>
				<td class=list><input type="checkbox" name="read[]" value="'.$users[$i].'" '.$read.'></td>
				<td class=list><input type="checkbox" name="write[]" value="'.$users[$i].'" '.$write.'></td>
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