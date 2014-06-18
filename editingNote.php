<?php
require 'config.php'; 
$err = false;
if( !empty($_POST) ){

	$insertArr = array();
	if(isset($_GET['cat']))
		$insertArr['catID_fk'] = $_GET['cat'];
	else
		$insertArr['catID_fk'] = $_POST['category'];
	
	$insertArr['issue'] = $_POST['issue'];
	$insertArr['note'] = addslashes( $_POST['note'] );
	$insertArr['example'] = $_POST['example'];
	
	if( isset($_GET['edit']) )
		$id = $db->updateQuery('eManual', $insertArr, 'eManualID='.$_GET['edit']);
	else
		$id = $db->insertQuery('eManual', $insertArr);
		
	if( $id ){
		echo "<script> parent.$.fn.colorbox.close(); parent.window.location.reload();  </script>";
	}else{
		$err = true;
	}
}

if(isset($_GET['edit'])){
	$eM = $db->selectSingleQueryArray('eManual', 'eManualID, catID_fk, issue, note, example', 'eManualID = "'.$_GET['edit'].'"');
	
}

?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Editing</title>   
	
	
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/aloha/css/aloha.css"/>	
	
	<script src="js/jquery-1.10.2.js"></script>	
    <script src="js/bootstrap.js"></script>	
	
</head>
<body>

<div>
	<h1>Add Comment/Note</h1>
</div>
<?php if( $err ){ ?>
	<p class="bg-danger">Error inserting category.  Please try again.</p>
<?php } ?>
<div>
<form role="form" method="POST" action="" onSubmit="return validateForm();" style="margin-left:20px;">
	<div style="margin-right:40px;" class="<?php if(isset($_GET['cat'])){ echo 'hidden'; } ?>">
		<select class="form-control" name="category" id="category">
			<option value="">Select subcategory</option>
			<?php 
				$cat = $db->selectQuery("editingCategory","catID, catName", "parentID = 0");				
				foreach( $cat AS $c ):					
					echo '<optgroup label="'.$c['catName'].'">';
					$subCat = $db->selectQuery("editingCategory","catID, catName", "parentID = ".$c['catID']);	
					foreach( $subCat AS $s ):
						$selected = '';
						if(isset($eM['catID_fk']) && $eM['catID_fk']==$s['catID'])
							$selected = ' selected="selected"';
						
						echo '<option value="'.$s['catID'].'" '.$selected.'>'.$s['catName'].'</option>';
					endforeach;
					echo '</optgroup>';
				endforeach;
			?>
		</select>
		<br/>
	</div>	
	<div style="margin-right:40px;">
		<input type="text" class="form-control" name="issue" id="issue" placeholder="Issue" value="<?php if(isset($eM['issue'])){ echo $eM['issue']; } ?>">
	</div>
	<br/>
	<div>		
		<textarea name="note" class="form-control editable" rows="12"><?php if(isset($eM['note'])){ echo stripslashes( $eM['note'] ); } ?></textarea>		
	</div>
	<br/>
	<div style="margin-right:40px;">
		<textarea name="example" class="form-control" rows="3" placeholder="Example"><?php if(isset($eM['example'])){ echo $eM['example']; } ?></textarea>
	</div>
	<br/>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>

<script type="text/javascript">
	Aloha = {};
	Aloha.settings = { sidebar: { disabled: true } };
</script>
<script type="text/javascript" src="js/aloha/require.js"></script>
<script src="js/aloha/aloha.js"
	data-aloha-plugins="common/ui,
		common/format,
		common/list,
		common/link,
		common/highlighteditables">
</script>
<script type="text/javascript">
	Aloha.ready( function() {
		var $ = Aloha.jQuery;
			$('.editable').aloha();
		});
</script>
</body>
</html>