<?php 
	include('_includes/functions.php');
	//include('_templates/header.php');
?>

<b>SVN Manager - Users</b>
	<br>
	<br>
	<?php 
	
	if(isset($_REQUEST['username']) && isset($_REQUEST['action']) && $_REQUEST['action'] == "delete") {
		$username = $_REQUEST['username'];
		
		if ($svnAdmin->htpasswd->deleteUser($username)) {
			
			foreach($svnAdmin->authz as $aut) {
				$aut->removeUser($username);	
			}
			
			
			print 'User "'.$username.'" deleted successfully';
		}
		else {
			echo 'User not found';
		}
	}
	
	?>


	<?php include('menu.php'); ?>
	<table class=list cellpadding=3 cellspacing=1>
		<tr>
			<td class=listtitle colspan="3"><strong>Users:</strong></td>
	
		</tr>
		<?php 
		
		$users = $svnAdmin->htpasswd->getUsers();
		
		
		if(count($users) == 0) {
			print '<tr>
				<td class="list">No users found</td>
			</tr>';
		}
		for ($i = 0; $i < count($users) ; $i++) {
			
			if($i % 2) {
				$cssClass = 'list';
			}
			else {
				$cssClass = 'list2';
			}
			
			print '<tr>
				<td class="'.$cssClass.'">'.$users[$i].'</td>
				<td class="'.$cssClass.'"><a href="?page=changeuser&username='.$users[$i].'">Change password</a></td>
				<td class="'.$cssClass.'"><a href="?page=users&action=delete&username='.$users[$i].'">Delete user</a></td>
			</tr>';
			
		}
		?>
	</table>
		
<?php 
	//include('_templates/footer.php');
?>