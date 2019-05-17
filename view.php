<?php

class View
{
	private $limit;
	private $page;
	
	public function __construct($limit, $page) 
	{
		$this->limit = $limit;
		$this->page  = $page;
	}
	
	public function getDefaultTemplate($results)
	{
		$content = '<table class="table table-striped">
					 <thead class="thead-dark">
					  <tr>
						<th class="text-center">Пользователь</th>
						<th class="text-center">E-mail</th>
						<th class="text-center">Задача</th>
						<th class="text-center">Стаутус</th>
					  </tr>
					 </thead>
					<tbody>';

		for( $i = 0; $i < count( $results->data ); $i++ ) 
		{
			$checked = $results->data[$i]['isdone'] == 1 ? "checked" : "";
			$content .= '<tr>'.
						'<td class="text-center">'.$results->data[$i]['username'].'</td>'.
						'<td class="text-center">'.$results->data[$i]['email'].'</td>'.
						'<td class="text-center">'.$results->data[$i]['task'].'</td>'.
						'<td class="text-center">'.
							'<div class="form-check form-check-inline">'.
								'<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" '.$checked.' disabled>'.
								'<label class="form-check-label" for="inlineCheckbox1">'.($checked == "checked" ? "Да" : "Нет").'</label>'.
							'</div>'.
						'</td>'.
					'</tr>';
		}
		$content .= '</tbody></table>';
		return $content;
	}
	
	public function getAdminTemplate($results)
	{
		$content = ' <table class="table table-striped">
					 <thead class="thead-dark">
					  <tr>
						<th class="text-center">Пользователь</th>
						<th class="text-center">E-mail</th>
						<th class="text-center">Задача</th>
						<th class="text-center">Стаутус</th>
						<th class="text-center"  colspan="2">Операции</th>
					  </tr>
					 </thead>
					<tbody>';

		for( $i = 0; $i < count( $results->data ); $i++ ) 
		{
			$checked = $results->data[$i]['isdone'] == 1 ? "checked" : "";
			$content .= '<tr>'.
						'<td class="text-center">'.$results->data[$i]['username'].'</td>'.
						'<td class="text-center">'.$results->data[$i]['email'].'</td>'.
						'<td class="text-center">'.$results->data[$i]['task'].'</td>'.
						'<td class="text-center">'.
							'<div class="form-check form-check-inline">'.
								'<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" '.$checked.' disabled>'.
								'<label class="form-check-label" for="inlineCheckbox1">'.($checked == "checked" ? "Да" : "Нет").'</label>'.
							'</div>'.
						'</td>'.
						'<td class="text-center">'.
							'<a class="btn btn-warning" href=?limit='.$this->limit.'&page='.$this->page.'&red_id='.$results->data[$i]['id'].'>Редактировать</a>'.
						'</td>'.
						'<td class="text-center">'.
							'<a class="btn btn-danger" href=?limit='.$this->limit.'&page='.$this->page.'&del_id='.$results->data[$i]['id'].'>Удалить</a>'.
						'</td>'.
					'</tr>';
		}
		$content .= '</tbody></table>';
		return $content;
	}
}
 ?>