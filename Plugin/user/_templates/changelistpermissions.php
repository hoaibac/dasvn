<?php 
	include('_includes/functions.php');
	include('_templates/header.php');
?>

<b>SVN Manager - Change admin permissions</b>
	<br>
	<br>
<?php 

		
	if(isset($_POST['change']) && $_POST['change'] == "list" && isset($svnAdmin->authz[$domain])) {
		$validUsers = array();
		foreach($_POST['read'] as $username) {
			if($svnAdmin->htpasswd->checkUser($username)) {
				$validUsers[]=$username;
			}
		}
		print 'List permission changed';
		$svnAdmin->authz[$domain]->setListAccess($validUsers);
	}

	function hadReadAccess($username, $authz) {
		global $domain;
		$users = $authz[$domain]->getListAccess();
		foreach($users as $user) {
			if($user == $username) {
				return true;
			}
		}
		return false;
	}

?>
	<?php include('_templates/menu.php'); ?>
	<form name="info" action="" method="post">
	<input type="hidden" name="page" value="changelistpermissions">
	<input type="hidden" name="change" value="list">

	
	
	<table class=list cellpadding=3 cellspacing=1>

		<tr><td class="listtitle" colspan="2">Who has acces to list repositories</td></tr>

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
		
			if(hadReadAccess($users[$i], $svnAdmin->authz)) {
				$read = 'checked="checked"';
			}
		
			print '<tr>
				<td class="'.$cssClass.'">'.$users[$i].'</td>
				<td class=list><input type="checkbox" name="read[]" value="'.$users[$i].'" '.$read.'></td>
			</tr>';
		}
		?>

		<tr><td class=listtitle colspan=2 align=right>
			<input type=submit name=create value="Save">
		</td></tr>

	</table>
</form>
<?php 


	include('_templates/footer.php');
?>