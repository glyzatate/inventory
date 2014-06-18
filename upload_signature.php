<?php 
	require 'config.php'; 
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Upload signature</title>   
	
	
	<link href="css/bootstrap.css" rel="stylesheet">
	
	<script src="js/jquery-1.10.2.js"></script>	
    <script src="js/bootstrap.js"></script>	
	
	<style type="text/css">
		#upload-div{overflow:hidden;}
	</style>
</head>
<body>
<div>
	<h1>Upload Signature</h1>
</div>
<div id="upload-div">
	<a name="attach_file"></a>
<?php 	
	$dir = 'uploads/employees/'.$_SESSION['u'].'/signature/';
	if (!is_dir($dir)){
		mkdir($dir, 0777);         
	}
	$uploader = new uploader($dir, "Choose File...","Start Upload","Cancel Upload");
	$uploader->set_multiple(FALSE);
	$uploader->accept_file_types('/\.(gif|jpe?g|png)$/i');
	$uploader->max_number_of_files(1);
	$uploader->set_filename('signature');
	$uploader->image_versions(100, 100, '');	
	$uploader->uploader_html();
?>
</div>
</body>
</html>