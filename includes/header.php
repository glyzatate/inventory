<?php 
	if(!isset($config))
		require 'config.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!--<meta charset="utf-8">-->
	<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo TITLE;?></title>

	<link rel="stylesheet" href="css/bootstrap.css"> <?php //Bootstrap core CSS ?>	
	<link rel="stylesheet" href="css/sb-admin.css">	<?php //Add custom CSS here ?>	
	<link rel="stylesheet" href="css/style.css"> <?php //Page Specific CSS ?>
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <?php //Page Specific CSS ?>
	
	<?php
		//for additional css defined on each page
		if( isset($css) ){
			foreach( $css AS $cs ):
				echo '<link rel="stylesheet" href="css/'.$cs.'">';
			endforeach;
		}
	?>
	

	<script src="js/jquery-1.10.2.js"></script>	
	<script src="js/bootstrap.js"></script>
</head>

<body>
	<div id="wrapper" style="position:relative;">
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo HOME_URL;?>"><?php echo COMPANY;?></a>
		</div>

		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<?php
			require 'includes/sidebar.php';
			
			require 'includes/navbar.php';
			//if( is_login() ){ require 'includes/navbar.php'; };
			?>
		</div>
	</nav>

	<div id="page-wrapper">
      