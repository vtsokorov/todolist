<?php 
include('config.php');
include('auth.php');
include('controller.php');

$model       = new Model();
$controller  = new Controller($model);
$controller->defineOrder();
$buttonLabel = "Добавить"; $dataEdit = null;

if(isset($_GET['red_id'])) {
	$buttonLabel = "Применить";
	if(isset($_POST['add'])) {
		$controller->updateTask();
	} 
	$dataEdit = $model->select('SELECT username, email, task, isdone FROM tasks WHERE ID = '.$_GET['red_id']);
} else if(isset($_POST['add'])) {
	$controller->addTask();
}
if (isset($_GET['del_id'])) { 
	$controller->deleteTask();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" media="screen" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<title>admin</title>
	
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

<div class="row h-100 justify-content-center align-items-center">
<h2>Управление задачами</h2>
</div>

<div class="pb-3">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="index.php">Главная</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="admin.php?do=logout">Выход</a></li>
				</li>
			</ul>
		</div>
	</nav>
</div>	

<div id="sortpanel">
	<form method="post" action="">
		<span>Сортировка: </span>
		<select name="sortvalue">
			<option <?= $_SESSION['username']; ?> value="username">По имени пользователя</option>
			<option <?= $_SESSION['email']; ?> value="email">По e-mail</option>
			<option <?= $_SESSION['isdone']; ?> value="status">По статусу выполнения</option>
		</select>
		<button type="submit" name="sort" class="btn btn-primary mb-2">Сортировать</button>
	</form>
</div>

<?php

	$currentPage = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '.php');
	echo $controller->getView($currentPage);
?>


<div class="container">
	<div class="row justify-content-center align-items-center">
		<form id="addDataForm" method="post" action="">
			<div class="form-row align-items-center">
				<div class="col-auto">
					<label class="sr-only" for="username">Имя:</label>
					<input class="form-control mb-2" id="name" type="text" name="username" size="28" placeholder="Введите имя" value="<?= isset($_GET['red_id']) ? $dataEdit[0]['username'] : ''; ?>" required="">
				</div>

				<div class="col-auto">
					<label class="sr-only" for="email">Email:</label>
					<input class="form-control mb-2" id="email" type="text" name="email" size="28" placeholder="Введите email" value="<?= isset($_GET['red_id']) ? $dataEdit[0]['email'] : ''; ?>" required="">
				</div>

				<div class="col-auto">
					<label class="sr-only" for="task">Задача:</label>
					<input class="form-control mb-2"  id="task" type="text" name="task" size="28" placeholder="Введите название задачи" value="<?= isset($_GET['red_id']) ? $dataEdit[0]['task'] : ''; ?>" required="">
				</div>
				
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="isdone" name="isdone" <?= isset($_GET['red_id']) ? $dataEdit[0]['isdone'] == 1 ? "checked" : "" : ''; ?> >
					<label class="form-check-label" for="isdone">Выполнение</label>
				</div>
			</div>	
			<div class="row justify-content-center align-items-center">
				<div class="col-auto">
					<button type="submit" name="add" class="btn btn-primary mb-2"><?= $buttonLabel; ?></button>
				</div>
			</div>	
		</form>
	</div>
</div>

<?php
	echo $controller->getLinks();
?>

</body>
</html>