<?php 
	include('_includes/functions.php');
	include('_templates/header.php');
?>

	<b>SVN Manager - Repositories</b>
	<br>
	<br>
	<?php 

	
		if(isset($_REQUEST['repository']) && isset($_REQUEST['action']) && $_REQUEST['action'] == "delete" && isset($svnAdmin->authz[$domain])) {
			$repository = $_REQUEST['repository'];
			
	
			
			if ($svnAdmin->authz[$domain]->deleteRepo($repository)) {
			
				$pathname = $svnAdmin->getSVNRepoDirectory() . '/' . $repository;
				$cmd = '/bin/rm -rf ' . $pathname . ' 2>&1';
				
				$phpmd5file = md5(time().'myHash').'.php';
				$public_html = getenv('HOME') . "/domains/".$domain."/public_html/". $phpmd5file;
				$http_html = 'http://'.$domain.'/'.$phpmd5file;				
				
				$php = '<?PHP'."\n".
						'exec("'.$cmd.'", $out, $err);'."\n".
						'print_r($out);'."\n".
						'print "<br />";'."\n".
						'print_r($err);'."\n".
						'print "<br />";'."\n".
						'?>';
				file_put_contents($public_html, $php);
				file_get_contents($http_html);
				unlink($public_html);
			
				
				print 'Repository "'.$repository.'" deleted successfully';
			}
			else {
				echo 'Repository not found';
			}
		}
	
	?>


	<?php include('_templates/menu.php'); ?>	

	<table class="list" cellpadding="3" cellspacing="1">
		<tr>
			<td class="listtitle" colspan="3"><strong>Repositorys:</strong></td>
		</tr>
		
		<?php 
		
		$repos = $svnAdmin->authz[$domain]->getRepos();

		if(count($repos) == 0) {
			print '<tr>
				<td class="list">No repositories found</td>
			</tr>';
		}
		for ($i = 0; $i < count($repos) ; $i++) {
			
			if($i % 2) {
				$cssClass = 'list';
			}
			else {
				$cssClass = 'list2';
			}
			
			print '<tr>
				<td class="'.$cssClass.'">'.$repos[$i]->getName().':'.$repos[$i]->getLocation().'</td>
				<td class="'.$cssClass.'"><a href="?page=changepermissions&repository='.$repos[$i]->getName().'&domain='.$domain.'">Change permissions</a></td>
				<td class="'.$cssClass.'"><a href="?page=repositories&action=delete&repository='.$repos[$i]->getName().'&domain='.$domain.'" onclick="return confirm(\'Are you sure you want to delete '.$repos[$i]->getName().'?\');">Delete</a></td>
			</tr>';
			
		}
		?>
	</table>
		
<?php 
	include('_templates/footer.php');
?>