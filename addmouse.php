<?php 

require 'config.php'; 
$err = false;
if( !empty($_POST) ){
	$insertArr_mouse = array();
	
	$mouse_invoiceno =  $_POST['mouse_invoiceno'];
	$mouse_label = $_POST['mouse_label'];
	$mouse_brand = $_POST['mouse_brand'];
	$mouse_model = $_POST['mouse_model'];
	$mouse_serial = $_POST['mouse_serial'];
	
	if($mouse_invoiceno) $insertArr_mouse['mouse_invoiceno'] = $mouse_invoiceno ;
	if($mouse_label) $insertArr_mouse['mouse_label'] = $mouse_label ;
	if($mouse_brand) $insertArr_mouse['mouse_brand'] = $mouse_brand ;
	if($mouse_model) $insertArr_mouse['mouse_model'] = $mouse_model ;
	if($mouse_serial) $insertArr_mouse['mouse_serial'] = $mouse_serial ;
	

	if( !empty($insertArr_mouse) )
		$mouseId = $db->insertQuery('mouse', $insertArr_mouse);

	
	if( $mouseId ){
		echo "okay ra!";
	}else{
		echo "Error!";
	}
}
else{
		echo "Error!";
	}
	
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	
<h1>Add Mouse</h1><hr>
<form action="" name="addmouseform" method="POST">
		<table border="0" cellpadding="3" cellspacing="3">				
			<tr><td><input type="text" name="mouse_invoiceno" id="mouse_invoiceno" placeholder="Invoice No." /></td></tr>			
			<tr><td><input type="text" name="mouse_label" id="mouse_label" placeholder="Label" /></td></tr>			
			<tr><td><input type="text" name="mouse_brand" id="mouse_brand" placeholder="Brand" /></td></tr>			
			<tr><td><input type="text" name="mouse_model" id="mouse_model" placeholder="Model"/></td></tr>
			<tr><td><input type="text" name="mouse_serial" id="mouse_serial" placeholder="Serial"/></td></tr>											
			<tr><td></td></tr>								
			<tr>				
				<td colspan="4" align="center"><input type="submit" name="" id="" placeholder="Brand" style="width:100px; height:30px;" value="Submit"></td>				
			</tr>	
		</table>	
</form>
	
	
<?php }  require "includes/footer.php"; ?>