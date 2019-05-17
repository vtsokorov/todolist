<?php

class MySqlDataBase {

	private static $db 		= false;
	private static $mysqli 	= false;
	private static $dbname = null;
	
	public function getConnection() {
		return self::$mysqli;
	}
	
	function __construct($address, $user, $password, $dbname) {
		self::$db = &$this;
		list($host, $port) = explode(':', $address);
		
		self::$dbname = $dbname;

		$mysqli = new mysqli($host, $user, $password, $dbname, $port);

		if ($mysqli->connect_error)
			throw new Exception("Connect failed: %s", $mysqli->connect_error);

		self::$mysqli = &$mysqli;
		self::$mysqli->query('SET NAMES utf8 COLLATE utf8_general_ci');
	}

	function MySqlDataBase($address, $user, $password, $dbname) {
		self::$db = &$this;
		list($host, $port) = explode(':', $address);

		$mysqli = new mysqli($host, $user, $password, $dbname, $port);

		if ($mysqli->connect_error)
			throw new Exception("Connect failed: %s", $mysqli->connect_error);

		self::$mysqli = &$mysqli;
		self::$mysqli->query('SET NAMES utf8 COLLATE utf8_general_ci');
	}
	
	public static function GetRows($rows, $single = false) {
		$result = array();

		if ($rows === false)
			return $result;

		if ($single) 
			return $rows->fetch_assoc();

		while ($row = $rows->fetch_assoc())
			array_push($result, $row);

		$rows->free();
		return $result;
	}
	
	public static function GetJson($rows, $single = false) 
	{
		$result = array();

		if ($rows === false)
			return $result;

		if ($single) 
			return $rows->fetch_assoc();

		while ($row = $rows->fetch_assoc()){
			array_push($result, $row);
		}

		$rows->free();
		return json_encode($result);;
	}
	
	public static function SelectJson($sql, $single = false) {
		$result = self::$mysqli->query($sql);
		return self::$db->GetJson($result, $single);
	}
	
	public static function Select($sql, $single = false) {
		$result = self::$mysqli->query($sql);
		return self::$db->GetRows($result, $single);
	}

	public static function Update($data, $table, $id) 
	{
		$fielads = self::GetFieldsName($table);	
		$query = "UPDATE ".$table." SET";
		$comma = " ";
		foreach($data as $column => $value) {
			//if( ! empty($value)) {
				$query .= $comma . $fielads[$column + 1]['COLUMN_NAME'] . " = '" . self::$mysqli->real_escape_string(trim($value)) . "'";
				$comma = ", ";
			//}
		}

		$query = $query . " WHERE ID = '".$id."' ";
		
		self::$mysqli->query($query);
		return self::$mysqli->affected_rows;
	}
	
	public static function Insert($data, $table) {
		$columns 	= "";
		$values 	= "";
		
		$fielads = self::GetFieldsName($table);
		
		foreach ($data as $column => $value) {
			$columns 	.= $columns ? ', ' : '';
			$columName = $fielads[$column + 1]['COLUMN_NAME'];
			$columns 	.= "$columName";
			$values 	.= $values 	? ', ' : '';
			$values 	.= "'$value'";
		}
		$sql = "INSERT INTO $table ($columns) VALUES ($values)";
		self::$mysqli->query($sql);
		return self::$mysqli->insert_id;
	}
	
	public static function GetFieldsName($table)
	{
		$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".self::$dbname."' AND TABLE_NAME = 'tasks'";
		return self::Select($sql);
	}
	
	public static function CountRows($table, $request = false) {
		$sql = "SELECT COUNT(*) FROM $table ";
		$sql .= $request ? $request : '';
		$result = self::$mysqli->query($sql);
		$count = $result->fetch_array();
		$result->free();
		return $count[0];

	}

	public static function Query($sql) {
		return self::$mysqli->query($sql);
	}
	
	public static function DeleteRow($where, $table) {
		$sql = "DELETE FROM ". $table ." WHERE ID = ".$where;
		return self::$mysqli->query($sql);
	}

	public static function Close() {
		self::$mysqli->close();
	}

	function __destruct() {
		self::$db->Close();
	}
	
	public function getError()
	{
		return $mysqli->error;
	}

}

?>