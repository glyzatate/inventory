<?php 
if( !isset( $_GET['id'] ) ){
	header("Location: editor.php");
	exit();
}

require 'config.php';
$kb_id = $_GET['id'];
$knbase = $db->selectSingleQueryArray("knowledgebase", "title, content, visibleTo", "id=$kb_id");

if(count($knbase)==0){
	header('Location: editor.php');
	exit;
}else if( 
	( $knbase['visibleTo']==0 && ( !$user->isSuperAdmin() || !$user->isHRAdmin() ) ) ||
	( $knbase['visibleTo']==1 && $user->getLocation() != 'PH' ) ||
	( $knbase['visibleTo']==2 && $user->getLocation() != 'US' )
){
	header('Location: editor.php');
	exit;
}


require 'includes/header.php';

if(is_login() && ( $user->isSuperAdmin() || $user->isHRAdmin() ) ){ ?>
<a href='editor.php?id=<?php echo $kb_id;?>' class='btn btn-primary'>Edit</a>
<button id="kb_post_delete" type="button" class='btn btn-default'>Delete</button>

<div class="pull-right">
	<button type="button" class="btn btn-success btn-xs">Visible to:</button>
	<?php 
	if( $knbase['visibleTo'] == 0 )
		echo '<u>Human Resouces</u>';
	else if( $knbase['visibleTo'] == 1 )
		echo '<u>All Cebu Staff</u>';
	else if( $knbase['visibleTo'] == 2 )
		echo '<u>All US Staff</u>';
	else 
		echo '<u>All Staffs</u>';
echo '</div>';
} ?>
	<h1><?= $knbase['title'] ?></h1>
	<?= $knbase['content'] ?>
<?php 

require 'includes/footer.php';
?>

<script type="text/javascript">
  	$("#kb_post_delete").click(function(){
  		var r=confirm("Are you sure you want to delete this post?");
  		if (r==true)
  		  {
  			$.ajax({
	  			type: "POST",
	  			url: "ajax.php",
	  			data: { action: "manual_delete", kb_id: "<?php echo $kb_id?>", type: "<?php echo $current_page ?>"}
			}).done(function( result ) {
	    		location.reload();
	  		});
  		  }
  	});
</script>
	