<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if( isset( $_GET['nRead'] ) ){
	$db->updateQuery('notifications', array( 'status' => '0'), 'userID_fk = "'.$user->getUID().'" AND noteID = "'.$_GET['nRead'].'"');
}

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<h1>Welcome '.$user->getFullName().'!!!</h1>
			<h3>'.$user->getTitle().'</h3>
			<p>'.ucfirst( $user->getDept() ).' Department</p>
		';		
	
	$notifications = $db->selectQuery('notifications', 'noteID, userID_fk, content, status', 'userID_fk='.$user->getUID().' ORDER BY noteID DESC' );	
	if( count($notifications) > 0 ){
		echo '<h3><u>Notifications</u></h3>';
		echo '<ol>';
		foreach($notifications AS $n):		
			echo '<li>';
			if( $n['status'] == 1 )
				echo '<span style="cursor:pointer;" onClick="nRead('.$n['noteID'].')"><b>'.$n['content'].'</b></span>';
			else
				echo $n['content'];
			echo '</li>';
		endforeach;
		echo '</ol>';
	}
			
}		

require "includes/footer.php";
?>
<script type="text/javascript">
	function nRead( nID ){
		window.location.href="http://employee.tatepublishing.net/index.php?nRead="+nID;
	}
</script>
