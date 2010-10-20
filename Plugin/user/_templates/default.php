<?php 
	include('_includes/functions.php');
	include('_templates/header.php');
?>
	
	<b>SVN Manager</b>
	<br>
	<br>
	<?php include('_templates/menu.php'); ?>

	<table class=list cellpadding=3 cellspacing=1>
		<tr>
			<td class="listtitle" colspan="4">Domains:</td>
		</tr>
<?php 

	$dir=opendir(getenv('HOME').'/domains/');

	while( ($curr=readdir($dir))) {

		if($curr != '.' && $curr != '..' && $curr != 'sharedip' && $curr != 'suspended' && $curr != 'default') {
			?>
			<tr>
				<td class="list"><?php print $curr ?></td>
				<td class="list"><a href='?page=repositories&domain=<?php print $curr ?>'>Repositories</a></td>
				<td class="list"><a href='?page=addrepository&domain=<?php print $curr ?>'>Add repositories</a></td>
				<td class="list"><a href='?page=changelistpermissions&domain=<?php print $curr ?>'>Admins</a></td>
			</tr>
			<?php 
		}
	}
?> 
	</table>

<?php 


	include('_templates/footer.php');
?>