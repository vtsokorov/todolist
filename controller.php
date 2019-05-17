<?php
include('model.php');
include('view.php');

class Controller
{
	private $model;
	
	private $limit;
	private $page;
	private $links;
	
	public function __construct($model)
	{
		$this->model = $model;
		$this->limit = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 3;
		$this->page  = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
		$this->links = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 3;
	}
	
	public function addTask()
	{
		$data = array(); 
		array_push($data, $_POST['username']);
		array_push($data, $_POST['email']);
		array_push($data, $_POST['task']);
		$this->model->insertRow($data);
		
		if(!isset($_SESSION['admin'])){
			header("Location: index.php?limit=".$this->limit."&page=".$this->page);
		}
		else
			header("Location: admin.php?limit=".$this->limit."&page=".$this->page);
		exit;
	}
	
	public function updateTask()
	{
		$data = array();
		array_push($data, $_POST['username']);
		array_push($data, $_POST['email']);
		array_push($data, $_POST['task']);
		array_push($data, (isset($_POST['isdone']))? 1 : 0);
		$id = $_GET['red_id'];
		
		$amount = $this->model->updateRow($data, $id);
		if (!$amount) {
			echo '<p>Ошибка удаления!</p>';
		}
		
		header("Location: admin.php?limit=".$this->limit."&page=".$this->page);
		exit;
	}
	
	public function deleteTask()
	{
		$id = $_GET['del_id'];
		$this->model->deleteRow($id);
		header("Location: admin.php?limit=".$this->limit."&page=".$this->page);
		exit;
	}
	
	public function defineOrder()
	{
		if(!isset($_SESSION['sortBy'])){
			$_SESSION['sortBy'] = 'username';
			$_SESSION['username'] = 'selected'; $_SESSION['email'] = ''; $_SESSION['isdone'] = '';
		}

		if(isset($_POST['sort']))
		{
			if($_POST['sortvalue'] == 'username') {
				$_SESSION['sortBy'] = 'username';
				$_SESSION['username'] = 'selected'; $_SESSION['email'] = ''; $_SESSION['isdone'] = '';
			}
			else if($_POST['sortvalue'] == 'email') {
				$_SESSION['sortBy'] = 'email';
				$_SESSION['username'] = ''; $_SESSION['email'] = 'selected'; $_SESSION['isdone'] = '';
			}
			else if($_POST['sortvalue'] == 'status') {
				$_SESSION['sortBy'] = 'isdone';
				$_SESSION['username'] = ''; $_SESSION['email'] = ''; $_SESSION['isdone'] = 'selected';
			}
		}
		$order = $_SESSION['sortBy'];
		$this->model->defineOrder($order);
	}
	
	public function getView($currentPage)
	{
		$results  = $this->model->selectRows($this->limit , $this->page);
		
		$view = new View($this->limit , $this->page);
		//if(!isset($_SESSION['admin'])){
		//	return $view->getDefaultTemplate($results);
		//}
		//else 
		//	return $view->getAdminTemplate($results);
		if($currentPage == 'admin')
			return $view->getAdminTemplate($results);
		else
			return $view->getDefaultTemplate($results);
	}
	
		
	public function getLinks()
	{
		return $this->model->getLinks($this->links);
	}
	
}
?>