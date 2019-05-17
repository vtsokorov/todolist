<?php
include('connection.php'); 
include('paginator.php');

class Model
{
	private $query;
	private $paginator;
	private $db;

	public function __construct()
	{
		$this->db = Connection::getDataBaseInstance();
		$this->query      = "SELECT id, username, email, task, isdone FROM tasks";
		$this->paginator  = new Paginator($this->db, $this->query);	
	}
	
	public function getQuery()
	{
		return $this->query;
	}
	
	public function defineOrder($order)
	{
		$this->query = $this->query." ORDER BY ".$order;
		$this->paginator = new Paginator( $this->db, $this->query );
	}
	
	public function getLinks($links)
	{
		return '<div class="row justify-content-center align-items-center">'.
			$this->paginator->createLinks( $links, 'pagination' ).
		'</div>';
	}
	
	public function selectRows($limit , $page)
	{
		return $this->paginator->getData($limit, $page);
	}
	
	public function deleteRow($id)
	{
		return $this->db->DeleteRow($id, 'tasks');
	}
	
	public function insertRow($data)
	{
		return $this->db->Insert($data, 'tasks');
	}
	
	public function updateRow($data, $id)
	{
		return $this->db->Update($data, 'tasks', $id);
	}
	
	public function select($sql)
	{
		return $this->db->Select($sql);
	}
}


?>