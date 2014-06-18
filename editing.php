<?php 
//array of additional scripts and css to load on the page
$css = array('colorbox.css');
$script = array('jquery.colorbox-min.js');	
require 'includes/header.php';
$kb_id = $_GET['id'];

?>
<div>
<?php
	if( $user->isSuperAdmin() OR $user->isEditingAdmin() ){
?>
	<div class="pull-right">
		<a href="editingCategory.php" class="btn btn-primary iframe">Add category/subcategory</a><br/><br/>
		<a href="editingNote.php" class="btn btn-primary note">Add Comments/Notes</a>
	</div>
<?php } ?>
	<?php
		$cat = $db->selectQuery("editingCategory","catID, catName", "parentID = 0"); 
		if( count( $cat ) > 0 ){
			echo '<h1>Categories</h1>
				<ul>';
			foreach( $cat AS $c ):
				echo '<li><a href="editingManual?id='.$c['catID'].'">'.ucfirst( $c['catName'] ).'</a></li>';
				$subcat = $db->selectQuery("editingCategory","catID, catName", "parentID = ".$c['catID']);
				if( count( $subcat ) > 0 ){
					echo '<ul>';
					foreach( $subcat AS $s ):
						echo '<li><a href="editingManual?id='.$s['catID'].'">'.ucfirst( $s['catName'] ).'</a></li>';
					endforeach;
					echo '</ul>';
				}				
			endforeach;
			echo '</ul>';
		}
	?>


</div>

<?php
require 'includes/footer.php';
?>

<script type="text/javascript">
	//for colorbox
	$(document).ready(function(){
		$(".iframe").colorbox({iframe:true, width:"40%", height:"55%"});
		$(".note").colorbox({iframe:true, width:"60%", height:"85%"});
	});

</script>