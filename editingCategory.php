<?php 
require 'config.php'; 
$err = false;
if( !empty($_POST) ){	
	$insertArr = array();
	$insertArr['catName'] = $_POST['catName'];
	
	if( $_POST['catType'] == 'subCat' )
		$insertArr['parentID'] = $_POST['category'];
	
	$id = $db->insertQuery('editingCategory', $insertArr);
	if( $id ){
		echo "<script> parent.$.fn.colorbox.close(); parent.window.location.reload();  </script>";
	}else{
		$err = true;
	}
}

?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Editing</title>   
	
	
	<link href="css/bootstrap.css" rel="stylesheet">
	
	<script src="js/jquery-1.10.2.js"></script>	
    <script src="js/bootstrap.js"></script>	
	
</head>
<body>

<div>
	<h1>Add category or subcategory</h1>
</div>
<?php if( $err ){ ?>
	<p class="bg-danger">Error inserting category.  Please try again.</p>
<?php } ?>
<div>


<form role="form" method="POST" action="" onSubmit="return validateForm();">
	<label for="name">Choose type:</label>
	<div>
		<label class="checkbox-inline">
			<input type="radio" name="catType" id="cat" value="cat"> Category
		</label>
		<label class="checkbox-inline">
			<input type="radio" name="catType" id="subCat" value="subCat" <?php if(isset($_GET['cat'])){ echo 'checked'; } ?>> Subcategory
		</label>
	</div>
	<br/>
	<div id="cSelect" class="form-group <?php if(!isset($_GET['cat'])){ echo 'hidden'; } ?>">
		<label for="Select category">Select category</label>
		<select class="form-control" name="category" id="category">
			<option value=""></option>
			<?php 
				$cat = $db->selectQuery("editingCategory","catID, catName", "parentID = 0");
				if(isset($_GET['cat']))
					$cID = $_GET['cat'];
				else
					$cID = 0;
				foreach( $cat AS $c ):
					echo '<option value="'.$c['catID'].'"';
					if( $cID == $c['catID'] )
						echo ' selected=selected ';
					echo '>'.$c['catName'].'</option>';
				endforeach;
			?>
		</select>
	</div>
	<div id="cName" class="<?php if(!isset($_GET['cat'])){ echo 'hidden'; } ?>">
		<label for="Category Name">Category Name</label>
		<input type="text" class="form-control" name="catName" id="catName">
	</div>
	<br/>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cat').click(function() {			
			$('#cSelect').removeClass('show');
			$('#cSelect').addClass('hidden');
			
			$('#cName').addClass('show');
			$('#cName').removeClass('hidden');
			
			$('#cName').removeClass('has-error');			
			$('#cSelect').removeClass('has-error');
			
			
		});	
		
		$('#subCat').click(function() {
			$('#cSelect').removeClass('hidden');
			$('#cSelect').addClass('show');
			
			$('#cName').addClass('show');
			$('#cName').removeClass('hidden');
			
			$('#cName').removeClass('has-error');			
			$('#cSelect').removeClass('has-error');
		});
		
		$('.form-control').click(function(){ 
			$(this).css('color','#000');
			$(this).parent().removeClass('has-error');
		});
		
	});
	
	function validateForm(){
		valid = true;
		cType = $("input[name=catType]:checked").val(); 
		if($("input[name=catType]:checked").size()==0){
			alert('Please select type.');
			valid = false;
		}else{		
			if(cType == 'subCat' && $('#category').val() == '' ){
				valid = false;
				$('#cSelect').addClass('has-error');
			}
			
			if($('#catName').val() == ''){
				valid = false;
				$('#cName').addClass('has-error');		
			}
			
			if(!valid)
				alert('Please input all fields.');
		}
		
		return valid;
	}
	

</script>
</body>
</html>