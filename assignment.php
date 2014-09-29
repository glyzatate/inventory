<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p id="topmenu">Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>

<style type="text/css">
.tablename {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	-webkit-border-top-left-radius:6px;
	-moz-border-radius-topleft:6px;
	border-top-left-radius:6px;
	-webkit-border-top-right-radius:6px;
	-moz-border-radius-topright:6px;
	border-top-right-radius:6px;
	-webkit-border-bottom-right-radius:6px;
	-moz-border-radius-bottomright:6px;
	border-bottom-right-radius:6px;
	-webkit-border-bottom-left-radius:6px;
	-moz-border-radius-bottomleft:6px;
	border-bottom-left-radius:6px;
	text-indent:0;
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#777777;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:50px;
	line-height:50px;
	width:60px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #ffffff;
}
.tablename:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.tablename:active {
	position:relative;
	top:1px;
}</style>	
<script type="text/javascript">
 //for colorbox
 
 $(document).ready(function(){
  $("#itroomid").colorbox({iframe:true, width:"40%", height:"55%"});
  //$(".note").colorbox({iframe:true, width:"60%", height:"85%"});
 });
</script> 
	<h1></h1><hr>	
	<table border="0" width="750px">
		<tr align="center">
			<td ><a href="#adminroom" >Admin Room</a></td>
			<td ><a href="#callroom" >Call Room</a></td>
			<td ><a href="#itroom" >IT Room</a></td>
			<td ><a href="#productionarea" >Production Area</a></td>
			<td ><a href="#wall" >Wall</a></td>			
		</tr>
	</table>
	
	<div id="adminroom"></div>
	<br/><br/>
	<div>
			<h2>Admin Room</h2>   
	</div>
	<table border="0" >
		<tr >
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">W1</a></td>
						<td ><a href="perassignment.php" class="tablename">W2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W3</a></td>
						<td ><a href="perassignment.php" class="tablename">W4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W5</a></td>		
						<td ><a href="perassignment.php" class="tablename">W6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W7</a></td>
						<td ><a href="perassignment.php" class="tablename">W8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W9</a></td>						
						<td ><a href="perassignment.php" class="tablename">W10</a></td>						
					</tr>
				</table>	
			</td>
		</tr>
	<table><br/>
	 <a href="#topmenu" >Back Top Menu</a>
	<div id="callroom"></div>
	<br/><br/>
	<div>
			<h2>Call Room</h2>
	</div>
	<table border="0" >
		<tr >
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">W1</a></td>
						<td ><a href="perassignment.php" class="tablename">W2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W3</a></td>
						<td ><a href="perassignment.php" class="tablename">W4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W5</a></td>		
						<td ><a href="perassignment.php" class="tablename">W6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W7</a></td>
						<td ><a href="perassignment.php" class="tablename">W8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W9</a></td>						
						<td ><a href="perassignment.php" class="tablename">W10</a></td>						
					</tr>
				</table>	
			</td>
		</tr>
	<table><br/>
	 <a href="#topmenu" >Back Top Menu</a> <br/>
	 
	<div id="itroom"></div><br/><br/>
	<div id="itroom">
			<h2>IT Room</h2>
	</div>
	<table border="0" >
		<tr >
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">W1</a></td>
						<td ><a href="perassignment.php" class="tablename">W2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W3</a></td>
						<td ><a href="perassignment.php" class="tablename">W4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W5</a></td>		
						<td ><a href="perassignment.php" class="tablename">W6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W7</a></td>
						<td ><a href="perassignment.php" class="tablename">W8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W9</a></td>						
						<td ><a href="perassignment.php" class="tablename">W10</a></td>						
					</tr>
				</table>	
			</td>
		</tr>
	<table>	<br/>
	 <a href="#topmenu" >Back Top Menu</a>
	 
	<div  name="productionarea" id="productionarea"></div><br/><br/>
	<div>
		<h2>Production Area</h2>
	</div>
	<table>
		<tr>
			<td width="255px"></td>
			<td></td>			
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">E1</a></td>
						<td ><a href="perassignment.php" class="tablename">E2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">E3</a></td>
						<td ><a href="perassignment.php" class="tablename">E4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">E5</a></td>		
						<td ><a href="perassignment.php" class="tablename">E6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">E7</a></td>
						<td ><a href="perassignment.php" class="tablename">E8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">E9</a></td>						
						<td ><a href="perassignment.php" class="tablename">E10</a></td>						
					</tr>
				</table>		
			</td>
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">D1</a></td>
						<td ><a href="perassignment.php" class="tablename">D2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">D3</a></td>
						<td ><a href="perassignment.php" class="tablename">D4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">D5</a></td>		
						<td ><a href="perassignment.php" class="tablename">D6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">D7</a></td>
						<td ><a href="perassignment.php" class="tablename">D8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">D9</a></td>						
						<td ><a href="perassignment.php" class="tablename">D10</a></td>						
					</tr>
				</table>	
			</td>
				<td>
				
			</td>
				<td>
				
			</td>
			<td>
				
			</td>
		</tr>
	<table>
	<br/>
	<table>
		<tr>
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">G1</a></td>
						<td ><a href="perassignment.php" class="tablename">G2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">G3</a></td>
						<td ><a href="perassignment.php" class="tablename">G4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">G5</a></td>		
						<td ><a href="perassignment.php" class="tablename">G6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">G7</a></td>
						<td ><a href="perassignment.php" class="tablename">G8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">G9</a></td>						
						<td ><a href="perassignment.php" class="tablename">G10</a></td>						
					</tr>
				</table>	

			</td>
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">F1</a></td>
						<td ><a href="perassignment.php" class="tablename">F2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">F3</a></td>
						<td ><a href="perassignment.php" class="tablename">F4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">F5</a></td>		
						<td ><a href="perassignment.php" class="tablename">F6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">F7</a></td>
						<td ><a href="perassignment.php" class="tablename">F8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">F9</a></td>						
						<td ><a href="perassignment.php" class="tablename">F10</a></td>						
					</tr>
				</table>	
			</td>
				<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">E1</a></td>
						<td ><a href="perassignment.php" class="tablename">E2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">E3</a></td>
						<td ><a href="perassignment.php" class="tablename">E4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">E5</a></td>		
						<td ><a href="perassignment.php" class="tablename">E6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">E7</a></td>
						<td ><a href="perassignment.php" class="tablename">E8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">E9</a></td>						
						<td ><a href="perassignment.php" class="tablename">E10</a></td>						
					</tr>
				</table>		
			</td>
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">D1</a></td>
						<td ><a href="perassignment.php" class="tablename">D2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">D3</a></td>
						<td ><a href="perassignment.php" class="tablename">D4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">D5</a></td>		
						<td ><a href="perassignment.php" class="tablename">D6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">D7</a></td>
						<td ><a href="perassignment.php" class="tablename">D8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">D9</a></td>						
						<td ><a href="perassignment.php" class="tablename">D10</a></td>						
					</tr>
				</table>	

			</td>

				<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">C1</a></td>
						<td ><a href="perassignment.php" class="tablename">C2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">C3</a></td>
						<td ><a href="perassignment.php" class="tablename">C4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">C5</a></td>		
						<td ><a href="perassignment.php" class="tablename">C6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">C7</a></td>
						<td ><a href="perassignment.php" class="tablename">C8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">C9</a></td>						
						<td ><a href="perassignment.php" class="tablename">C10</a></td>						
					</tr>
				</table>	
			</td>
				<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">B1</a></td>
						<td ><a href="perassignment.php" class="tablename">B2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">B3</a></td>
						<td ><a href="perassignment.php" class="tablename">B4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">B5</a></td>		
						<td ><a href="perassignment.php" class="tablename">B6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">B7</a></td>
						<td ><a href="perassignment.php" class="tablename">B8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">B9</a></td>						
						<td ><a href="perassignment.php" class="tablename">B10</a></td>						
					</tr>
				</table>		
			</td>
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">A1</a></td>
						<td ><a href="perassignment.php" class="tablename">A2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">A3</a></td>
						<td ><a href="perassignment.php" class="tablename">A4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">A5</a></td>		
						<td ><a href="perassignment.php" class="tablename">A6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">A7</a></td>
						<td ><a href="perassignment.php" class="tablename">A8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">A9</a></td>						
						<td ><a href="perassignment.php" class="tablename">A10</a></td>						
					</tr>
				</table>	
			</td>
		</tr>
	<table><br/>
	 <a href="#topmenu" >Back Top Menu</a>
	 
	<div id="wall"></div><br/><br/>
	<div>
			<h2>Wall</h2>
	</div>
	<table border="0" >
		<tr >
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">W1</a></td>
						<td ><a href="perassignment.php" class="tablename">W2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W3</a></td>
						<td ><a href="perassignment.php" class="tablename">W4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W5</a></td>		
						<td ><a href="perassignment.php" class="tablename">W6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W7</a></td>
						<td ><a href="perassignment.php" class="tablename">W8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W9</a></td>						
						<td ><a href="perassignment.php" class="tablename">W10</a></td>						
					</tr>
				</table>	
			</td>
		</tr>
	<table><br/>
	 <a href="#topmenu" >Back Top Menu</a>
	
	
	<div align="center">
		
	
<?php }  require "includes/footer.php"; ?>

