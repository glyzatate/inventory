<?php 
require 'includes/header.php';

if(isset($_POST['pt_user_btn'])){
	if(empty($_POST['username'])){
		$error['username'] = "status shouldn't be empty.";
	}
	else{
		$count = $db->selectSingleQuery("pt_users", "COUNT(id)", "username = '{$_POST['username']}'");
		if($count > 0)
			$error['username'] = "Username already exist.";
	}
	if(sizeof($error) == 0){
		unset($_POST['pt_user_btn']);
		$_POST['pt_username'] = $_SESSION['u'];
		$db->insertUpdateQuery("pt_users", $_POST);
		$update[] = "New PT User added!";
		unset($_POST);
	}
}
?>
<?php echo get_error();?>
<div id="accordion">
<!-- USERS -->
<h3 style="font-weight: bold;">PT Authorized Users</h3>
<div>
<?php 
	$pt_users = $db->selectQuery("pt_users", "*");
	if(is_array($pt_users)){
		foreach($pt_users AS $k => $v){
			echo "<div id='container_user{$v['id']}' style='margin-bottom: 15px;'>";
			$delete = $_SESSION['u'] != $v['username']? "[<a id='pt_user{$v['id']}'>delete</a>]" : "";
			$level = $v['level']==1?"HR" : "Hiring Manager";
			echo "<p>{$v['username']} [<b>{$level}</b>]<span style='margin-left: 20px;font-size: 0.8em;'>Date added: {$v['timestamp']}, Added By: <b>{$v['pt_username']}</b></span> $delete</p>";
			echo "</div><div id='container_user_prompt{$v['id']}'></div>";
			$loader = get_ajax_loader("#container_user_prompt{$v['id']}");
			echo <<<EOF
			<script>
				$("#pt_user{$v['id']}").click(function(){
					$loader
					$.ajax({
			  			type: "POST",
			  			url: "ajax.php",
			  			data: { action: "delete_user", id: "{$v['id']}" }
					}).done(function( result ) {
			    		$("#container_user_prompt{$v['id']}").html(result);
			  		});
			  	});
			</script>
EOF;
		}
	}
	echo "<div style='margin-bottom: 15px;'>";
	echo "<p><strong>Add New PT User</strong></p>";
	$form->formStart("","POST",'class="bs-example form-horizontal" style="width: 600px;"');
	$form->text("username",$_POST['status'],'class="form-control"',"PT Username","",TRUE);
	$level_opt = array(1=>"HR",2=>"Hiring Manager");
	$form->select("credential",$_POST['credential'],$level_opt,'class="form-control"',"Credential Level");
	$form->button("pt_user_btn","Add PT User","class='btn btn-primary'");
	$form->formEnd();
	echo "</div>";
?>
</div><!-- /USERS -->
</div><!-- /Accordion -->
<?php 
require 'includes/footer.php';
?>