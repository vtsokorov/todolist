<?php
include('mysql.php'); 

class Connection
{
	public static function getDataBaseInstance(){
		//return new MySqlDataBase('localhost:3306', 'root', 'root', 'todolist');
		return new MySqlDataBase('mysql.zzz.com.ua:3306', 'freeice', 'Callisto1610', 'vyacheslavt');
	}
}

?>