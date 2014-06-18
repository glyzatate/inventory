<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

//Local
//require '../../config.php';

//Online
session_start();
define('DIR_DOWNLOAD', $_SERVER['DOCUMENT_ROOT'].'/');
define ('HTTP_SERVER' , 'http://'.$_SERVER['HTTP_HOST'].'/');

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

$options = array();

if( isset($_SESSION['upload']['upload_dir']) ){
	$options['upload_dir'] = DIR_DOWNLOAD . $_SESSION['upload']['upload_dir'];
	$options['upload_url'] = HTTP_SERVER  . $_SESSION['upload']['upload_dir'];
}else{
	$options['upload_dir'] = DIR_DOWNLOAD . "uploads/";
	$options['upload_url'] = HTTP_SERVER  . "uploads/";
}

if( isset($_SESSION['upload']['max_number_of_files']) )
	$options['max_number_of_files'] = $_SESSION['upload']['max_number_of_files'];

if(isset($_POST) ){
	if( !empty($_POST['upload-dir']) ){
		$options['upload_dir'] = DIR_DOWNLOAD . $_POST['upload-dir'];
		$options['upload_url'] = HTTP_SERVER . $_POST['upload-dir'];
	}
	
	if( !empty($_POST['newFileName']) )
		$options['newFilename'] = $_POST['newFileName'];	
	if( !empty( $_POST['accept_file_types'] ) )
		$options['accept_file_types'] = $_POST['accept_file_types'];
	if( !empty( $_POST['image_width'] ) || !empty( $_POST['image_height'] ) ){
		$options['image_versions'] = array(
									$_POST['image_dir'] => array(
											'max_width' => $_POST['image_width'],
											'max_height' => $_POST['image_height'],
											'jpeg_quality' => 90
										)
									);
	}	
} 

$upload_handler = new UploadHandler($options);