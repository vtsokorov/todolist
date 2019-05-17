<?php
if(isset($_GET['do']) && $_GET['do'] == 'logout'){
	unset($_SESSION['admin']);
	session_destroy();
}

if(!isset($_SESSION['admin'])){
	header("Location: enter.php");
	exit;
}
?>