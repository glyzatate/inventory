<?php
session_start();

date_default_timezone_set('Asia/Hong_Kong');

function __autoload($class_name){
	require_once 'classes/'.$class_name.'.class.php'; 
}
$dbname="projectTracker";
$user="pt";
$pass="juneSnow&764";
$host="ptracker.clhfapw0bgm7.us-east-1.rds.amazonaws.com";
$ptDb = new database($dbname, $user, $pass, $host);
$dbname="inventory_tate";
$user="root";
//$pass="";
$pass="seabiscuit";
$host="129.3.252.99";
$db = new database($dbname, $user, $pass, $host);
$form = new formHelper();
$content = new content($db);
$settings = new setting($db);
$manuals = new manuals($db);
$user = new staff($db);
$user->getUserInfo();
define("COMPANY","Tate Publishing Philippines");
define("TITLE",COMPANY." - Self Service");
define("PROJECT","tatepubselfserv/");
define("HOME_URL","http://localhost/".PROJECT);
define('DIR_DOWNLOAD', $_SERVER['DOCUMENT_ROOT'].'/'.PROJECT);
define('HTTP_SERVER', 'http://'.$_SERVER['HTTP_HOST'].'/'.PROJECT);

$error = array();
$update = array();
$current_page = strstr(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']),".",true);

require 'includes/functions.php';


if((!isset($no_login)) && !is_login() && $current_page!='login' && $current_page!='index'){
	header("Location: index.php");
	exit();
}

$config = true;

?>