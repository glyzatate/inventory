<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	
<h1>Add Keyboard</h1><hr>
<form action="" name="" method="POST">
		<table border="0" cellpadding="3" cellspacing="3">
			
			
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