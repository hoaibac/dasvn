<?php 
	include('_includes/functions.php');
	include('_templates/header.php');
?>

<b>SVN Manager - Users</b>
	<br>
	<br>
<?php 
	$username = '';

	if(isset($_POST['username']) && strlen($_POST['username']) > 0) {
		$username = $_POST['username'];
		if(isset($_POST['password1']) && isset($_POST['password2'])) {
			
			$password1 = $_POST['password1'];
			$password2 = $_POST['password2'];
			
			$pattern = "/^([a-z0-9_])+$/";
			if(!preg_match($pattern,$username)) {
				echo 'username contains invalid characters!';
				$username = '';
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
			else if ($svnAdmin->htpasswd->checkUser($username)) {
				print "User already exists";
			}
			else {
				echo 'User added successfully!';
				$svnAdmin->htpasswd->addUser($username, $password1);
				$username = '';
			}
		}
	}
?>
	<?php include('_templates/menu.php'); ?>
	<form name="info" action="" method="post">
	<input type="hidden" name="page" value="adduser">
	<table class=list cellpadding=3 cellspacing=1>

		<tr><td class=listtitle colspan=2>Create user</td></tr>

		<tr><td class=list>Username:</td><td class=list><input type=text name="username" value="<?= $username ?>" size=20></td></tr>
		<tr><td class=list>Password:</td><td class=list><input type=password name="password1" size=20></td></tr>
		<tr><td class=list>Repeat password:</td><td class=list><input type=password name="password2" size=20></td></tr>

		<tr><td class=listtitle colspan=3 align=right>
			<input type=submit name=create value="Create">
		</td></tr>

	</table>
</form>
<?php 
	include('_templates/footer.php');
?>