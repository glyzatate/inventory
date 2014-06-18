<?php 
require 'config.php';

if(!is_login() && !$user->isSuperAdmin()){
	header("Location: index.php");
	exit();
}

$error = '';
if(isset($_POST['new_post'])){
	if(empty($_POST['title'])){
		$error .= "Title shouldn't be empty.<br/>";
	}
	if(empty($_POST['content'])){
		$error .= "Body shouldn't be empty.";
	}
	if( empty($error) ){
		unset($_POST['new_post']);
		$id = $db->insertUpdateQuery("knowledgebase", $_POST);
		header("Location: knowledgebase.php?id=".$id);
	}
}
if(isset($_GET['id'])){
	$result = $db->selectSingleQueryArray("knowledgebase", "title, content, id, visibleTo", "id=".$_GET['id']);
	$_POST = $result;
	$_POST['id'] = $_GET['id'];
}

//array of additional scripts and css to load on the page
$css = array('aloha/css/aloha.css', 'jquery-ui/jquery-ui.css', 'colorbox.css');
$script = array('jquery-ui.min.js', 'aloha/require.js', 'jquery.colorbox-min.js');	
require 'includes/header.php';
?>
<style>#reason-aloha{ width:1007px!important; }</style>
<?php if(isset($_GET['add_post']) || isset($_POST['id']) || isset($_POST['em_id'])){?>
<div class='clear' style="padding-top:5px;"></div>
<?php if(!empty($error)){ ?> <p class="bg-danger"><?php echo '<b style="color:red;">Error!</b><br/>'.$error ?></p><?php } ?>
<?php 
	$form->formStart('', 'POST');
	$form->setEditable(TRUE);
	if(isset($_POST['id'])) $form->hidden("id",$_POST['id']);	
	$form->text("title",$_POST['title'],'class="form-control" style="width:1007px;"',"Title:");
?>
	<p style="line-height:5px">&nbsp;</p>
	<div class="form-group ">		
		<label class="col-lg-2 control-label" for="inputEmail"><br/></label>
			<div class="col-lg-10">
			<span>Visible to: </span>
			<label class="checkbox-inline">
				<input name="visibleTo" id="visibleTo" value="0" type="radio" <?php if(isset($_POST['visibleTo']) && $_POST['visibleTo']==0){ echo 'checked'; } ?>> Human Resources
			</label>
			<label class="checkbox-inline">
				<input name="visibleTo" id="visibleTo" value="1" type="radio" <?php if(isset($_POST['visibleTo']) && $_POST['visibleTo']==1){ echo 'checked'; } ?>> All Cebu Staff
			</label>
			<label class="checkbox-inline">
				<input name="visibleTo" id="visibleTo" value="2" type="radio" <?php if(isset($_POST['visibleTo']) && $_POST['visibleTo']==2){ echo 'checked'; } ?>> All US Staff
			</label>
			<label class="checkbox-inline">
				<input name="visibleTo" id="visibleTo" value="3" type="radio" <?php if(isset($_POST['visibleTo']) && $_POST['visibleTo']==3){ echo 'checked'; } ?>> All Staff
			</label>
				<a class="iframe pull-right" style="padding-right:10px;" href="/upload_file.php"><button class="btn btn-success" type="button">Upload file / Get link</button></a>				
		</div>
		
	</div>
	<p style="line-height:5px">&nbsp;</p>
<?php	
	$form->textarea("content",$_POST['content'],'id="reason" class="editable form-control" rows="20"',"Body:");
	echo "<p>&nbsp;</p>";
	$label = isset($_POST['id'])? "Update":"Add";
	$link = isset($_POST['id'])? "knowledgebase.php?id=".$_POST['id']:"editor.php";
	echo '<div class="form-group">
		<label class="col-lg-2 control-label" for="button"></label>
		<div class="col-lg-10">
		<button class="btn btn-primary" name="new_post" type="submit">'.$label.'</button>
		<a href="'.$link.'">
			<button class="btn btn-default" name="" type="button">Cancel</button>
		</a>
		</div>
	</div>';
	
	$form->formEnd();

	}else{ ?>
<style>  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
  html>body #sortable li { height: 1.5em; line-height: 1.2em; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
  
</style>
<div class="clear"></div>
<?php 
	$class = '';
	if( $user->isSuperAdmin() || $user->isHRAdmin() ){
		$class = "class='ui-state-default'";
		echo '<a href="editor.php?add_post=1" class="pull-right"><button class="btn btn-primary" type="button">Add New Post</button></a>';
	}
	
	echo '<h3>Knowledge Base Posts</h3>';
	
	//0-HR only; 1-all cebu staff; 2-all US staff; 3-all staff
	$condition = '';
	if(!$user->isSuperAdmin() && !$user->isHRAdmin()){
		$condition .= 'AND ( visibleTo = 3';
		if( $user->getLocation()=='US')
			$condition .= ' OR visibleTo = 2';
		if( $user->getLocation()=='PH')
			$condition .= ' OR visibleTo = 1';				
		if( $user->getDeptNum() == 13 )
			$condition .= ' OR visibleTo = 0';
		$condition .= ')';
	}
	$side_data = '';
	$manuals = $db->selectQuery('knowledgebase', 'id, title, visibleTo', 'active=1 '.$condition.' ORDER BY level');	
	foreach( $manuals AS $e ):
		$side_data .= '<li id="'.$e['id'].'" '.$class.'><a href="knowledgebase.php?id='.$e['id'].'">'.$e['title'].'</a>';
		
		if( $user->isSuperAdmin() || $user->isHRAdmin() ){
			$side_data .= '&nbsp;&nbsp;&nbsp;<span style="font-size:12px; color:red;">Visible to: <b>';
			if( $e['visibleTo']==0 ) $side_data .= 'Human Resource';
			else if( $e['visibleTo']==1) $side_data .= 'All Cebu Staff';
			else if( $e['visibleTo']==2 ) $side_data .= 'All US Staff';
			else $side_data .= 'All Staff';
			$side_data .= '</b></span>';
			
		}
		$side_data .= '</li>';
	endforeach;	
?>

<ul id="sortable">
	<?php echo $side_data; ?>
</ul>
<?php 
	if( empty( $side_data ) )
		echo 'No posts.';
if( ( $user->isSuperAdmin() || $user->isHRAdmin() ) && !empty( $side_data ) ){ ?>
<br/><br/><span style="font-size:12px;">**You can drag each posts to sort.  Click "Save" when done.</span><br/>
<button class='btn btn-primary' type='button' id='save_sort'>Save</button>
<?php }
	} ?>
<?php 
require 'includes/footer.php';
?>

<script>
	Aloha = {};
	Aloha.settings = { sidebar: { disabled: true } };
</script>
<!-- load the Aloha Editor core and some plugins -->
<script src="js/aloha/aloha.js"
	data-aloha-plugins="common/ui,
		common/format,
		common/list,
		common/link,
		common/highlighteditables">
</script>

<!-- make all elements with class="editable" editable with Aloha Editor -->
<script type="text/javascript">
	Aloha.ready( function() {
		var $ = Aloha.jQuery;
			$('.editable').aloha();
		});
		
	//for colorbox
	$(document).ready(function(){
		$(".iframe").colorbox({iframe:true, width:"60%", height:"80%"});
	});


	$(function() {
		$( "#sortable" ).sortable({
		  placeholder: "ui-state-highlight"
		});
		$( "#sortable" ).disableSelection();
	});
	$("#save_sort").click(function() {
		var liIds = $('#sortable li').map(function(i,n) {
			return $(n).attr('id');
		}).get().join(',');
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: { action: "knowledgebase_sort", sort_array: liIds, type: "<?php echo $_GET['type'];  ?>"}
		}).done(function( result ) {
			alert(result);
			location.reload();
		});
	});
	
</script>