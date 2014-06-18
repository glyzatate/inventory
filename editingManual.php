<?php 
if(!isset($_GET['id'])){
	header("Location: editing.php");
	exit();
}
//array of additional scripts and css to load on the page
$css = array('colorbox.css');
$script = array('jquery.colorbox-min.js');	
require 'includes/header.php';

if(isset($_GET['delNote'])){
	$db->deleteQuery('eManual', 'eManualID='.$_GET['delNote'].' LIMIT 1');
}

$catID = $_GET['id'];
$cat = $db->selectSingleQueryArray('editingCategory', 'catID, catName, parentID', 'catID = "'.$catID.'"');

?>
<div>
<?php
	if($cat['parentID'] == 0){
		$subCat = $db->selectQuery('editingCategory', 'catID, catName', 'parentID='.$cat['catID']);
		if( $user->isSuperAdmin() OR $user->isEditingAdmin() )
			echo '<a href="editingCategory.php?cat='.$cat['catID'].'" class="btn btn-primary iframe pull-right">Add subcategory</a>';
		echo '<h1>'.$cat['catName'].'</h1>';		
		echo '<ul>';		
		foreach($subCat AS $s):
			echo '<li><a href="editingManual?id='.$s['catID'].'">'.$s['catName'].'</a></li>';
		endforeach;
		echo '</ul>';
	}else{
		$mainCat = $db->selectSingleQueryArray('editingCategory', 'catID, catName, parentID', 'catID = "'.$cat['parentID'].'"');
		if( $user->isSuperAdmin() OR $user->isEditingAdmin() )
			echo '<a href="editingNote.php?cat='.$cat['catID'].'" class="btn btn-primary note pull-right">Add Comments/Notes</a>';
		echo '<h1><a href="editingManual?id='.$mainCat['catID'].'">'.$mainCat['catName'].'</a></h1>';	
		echo '<h2>-  '.$cat['catName'].'</h2>';
		
		$query = $db->selectQuery('eManual', 'eManualID, issue, note, example', 'catID_fk='.$cat['catID']);	
		if( count($query) > 0 ){
			echo '<table class="table table-hover table-striped">
				<thead>
				<tr>
					<th width="20%">Issues</th>
					<th width="50%">Comments/Notes</th>
					<th width="20%">Examples</th>';
			if( $user->isSuperAdmin() OR $user->isEditingAdmin() )		
				echo '<th width="10%"><br/></th>';
				
				echo '</tr>
				</thead>';
			
			foreach($query AS $q):
				echo '
					<tr>
						<td>'.$q['issue'].'</td>
						<td>'.stripslashes( $q['note'] ).'</td>
						<td>'.$q['example'].'</td>';
				if( $user->isSuperAdmin() OR $user->isEditingAdmin() ){
						echo '<td>
							<a href="editingNote.php?edit='.$q['eManualID'].'" class="btn btn-primary btn-xs note">Edit</a>
							<a onClick="delNote('.$catID.', '.$q['eManualID'].');" class="btn btn-danger btn-xs">Delete</a>
						</td>';
				}
				echo '</tr>';
			endforeach;
			echo '</table>';
		}
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
	
	function delNote( catID, id ){
		var c = confirm('Are you sure you want to delete this note?');
		if(c){
			window.location.href='editingManual.php?id='+catID+'&delNote='+id;
		}
	}

</script>