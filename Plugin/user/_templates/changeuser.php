<?php 
	include('_includes/functions.php');
	include('_templates/header.php');
?>

<b>SVN Manager - Users</b>
	<br>
	<br>
	
	<?php 
	
	if(isset($_REQUEST['username']) && strlen($_REQUEST['username']) > 0) {
		$username = $_REQUEST['username'];
		if(isset($_POST['newPassword1']) && isset($_POST['newPassword2'])) {
			
			$password1 = $_POST['newPassword1'];
			$password2 = $_POST['newPassword2'];
		
			$pattern = "/^([a-z0-9_])+$/";
			if(!preg_match($pattern,$username)) {
				echo 'username contains invalid characters!';
			}
			else if (strlen($username) <= 1) {
				print "username is to short";
			}
			else if (strlen($username) > 15) {
				print "username is to long";
			}
			else if (strlen($password1) <= 5) {
				print "Password is to short";
			}
			else if (strlen($password2) > 25) {
				print "Password is to long";
			}
			else if ($password1 != $password2) {
				print "Password does not match";
			}
			else if (!$svnAdmin->htpasswd->checkUser($username)) {
				print "User does not exists";
			}
			else {
				echo 'User changed successfully!';
				$_POST['action'] = 'list';
				$svnAdmin->htpasswd->changePassword($username, $password1);
			}
		}
	}
	
	?>
	<?php include('_templates/menu.php'); ?>
		<form name="info" action="" method="post">
			<input type="hidden" name="page" value="changeuser">
			<input type="hidden" name="username" value="<?= $username ?>">
			<input type="hidden" name="action" value="changePassword">
			<table class=list cellpadding=3 cellspacing=1>
	
				<tr><td class=listtitle colspan=2>Change user Password</td></tr>
		
				<tr><td class=list>Username:</td><td class=list><input type="text" name="uname" value="<?= $username ?>" disabled="disabled" size="20"></td></tr>
				<tr><td class=list>Password:</td><td class=list><input type=password name="newPassword1" size=20></td></tr>
				<tr><td class=list>Repeat password:</td><td class=list><input type=password name="newPassword2" size=20></td></tr>
		
				<tr><td class=listtitle colspan=3 align=right>
					<input type="submit" name="cancel" value="Cancel"> <input type=submit name=create value="Change">
				</td></tr>
		
			</table>
		</form>
<?php 
	include('_templates/footer.php');
?>