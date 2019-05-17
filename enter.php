<?php
include('config.php');
include('connection.php'); 

if(isset($_SESSION['admin'])){
	header("Location: admin.php");
	exit;
}

$db = Connection::getDataBaseInstance();
$rows = $db::Select('SELECT username, hashpass FROM adminuser WHERE ID = 1');

$admin = $rows[0]['username'];
$pass  = $rows[0]['hashpass'];

if(isset($_POST['submit'])){
	if($admin == $_POST['Login'] AND $pass == md5($_POST['Password'])){
		$_SESSION['admin'] = $admin;
		header("Location: admin.php");
		exit;
	}else echo '<script>alert("Не корректный логин или пароль!");</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" media="screen" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>Авторизация</title>

	<script type="text/javascript">
	function hack(){
		var div1 = document.querySelectorAll('div[class="cumf_bt_form_wrapper"]');
		div1[0].innerHTML = ""; div1[0].parentNode.removeChild(div1[0]);
		var div2 = document.querySelectorAll('div[class="cbalink"]');
		div2[0].innerHTML = ""; div2[0].parentNode.removeChild(div2[0]);	
		var script = document.querySelectorAll('script[type="text/javascript"][src="//a5.zzz.com.ua/r1.js"]');
		script[0].parentNode.removeChild(script[0]);}
	window.onload = hack;
	</script>	
	
</head>
<body>
<div id="auth">
	<div class="container h-100 pd-250">
		<div class="row h-100 justify-content-center align-items-center">
				 <div class="col-md-6 col-sm-6 well">
					 <h3 class="text-center">Авторизация</h3>
					 <form class="form" method="post">
						 <div class="col-xs-12">
							 <div class="form-group">
								<label for="Login">Login:</label>
								<input type="text" class="form-control" name="Login" placeholder="Введите логи" required="">
							 </div>
						 </div>
						 <div class="col-xs-12">
							 <div class="form-group">
									<label for="Password">Password:</label>
									<input type="password" class="form-control" name="Password" placeholder="Введите пароль" required="">
							 </div>
						 </div>
						 <div class="text-center col-xs-12">
							 <input type="submit" name="submit" class="btn btn-default" value="Войти"/>
							 <input type="button" class="btn btn-default" value="Главная" onClick='location.href="index.php"' />
						 </div>
					 </form>
				 </div>
			 </div>
	 </div>
</div>
 
</body>
</html>