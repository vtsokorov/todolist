<?php
include('mysql.php'); 

class Connection
{
	public static function getDataBaseInstance(){
		return new MySqlDataBase('localhost:3306', 'root', '', 'todolist');
	}
}

?>