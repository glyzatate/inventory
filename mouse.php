<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	mouse here
	
	
<?php }  require "includes/footer.php"; ?>
<script type="text/javascript">
	function nRead( nID ){
		window.location.href="http://employee.tatepublishing.net/index.php?nRead="+nID;
	}
</script>
