<?php
class ZoneDefault extends AppZone
{
	public function initZone($p, $z)
	{
		$this->loggedInUser = RequestApp::getLoggedInUser();
		if(!$this->loggedInUser && $p[0] != 'default')
			BaseRedirect('default');
	}
	
	public function pageDefault() {}
	
	public function postDefault()
	{
		if(RequestApp::auth($_POST['username'], $_POST['password']))
			$this->redirect('list');
	}
	
	public function pageList($p, $z)
	{
		$filterId = isset($p[1]) ? $p[1] : '';
		$filter = $filterId ? new Filter($filterId) : null;
		// if($filterId)
		// 	echo_r(json_decode($filter->content));
		
		$this->assign('requests', $this->loggedInUser->getPermittedRequests());
		$this->assign('config', Config::get('app.filter'));
		
		//	do any database lookups that need to be done to fill out the config data
		$config = Config::get('app.filter');		
		foreach($config['fields'] as $fieldName => $fieldInfo)
		{
			if($fieldInfo['type'] == 'discreet' && !isset($fieldInfo['list']))
				$config['fields'][$fieldName]['list'] = SqlFetchSimpleMap("SELECT id, :nameField:identifier FROM :tableName:identifier", 'id', $fieldInfo['display_field'],
					array('nameField' => $fieldInfo['display_field'], 'tableName' => $fieldInfo['references']));
		}
		$this->assign('config', $config);
		
		$filterList = array('' => '');
		$options = SqlFetchSimpleMap("SELECT id, name from filter order by name", 'id', 'name', array());
		foreach($options as $key => $val)
			$filterList[$key] = $val;
		// echo_r(json_decode($filter->content));
		$this->assign('filter', $filter);
		$this->assign('filterId', $filterId);
		$this->assign('filterList', $filterList);
	}
	
	public function pageListBody($p, $z)
	{
		$where = Filter::jsonToSql($_GET['filterData']);
		$sql = "SELECT
					*
				from
					request
				where
					$where";
		$requests = DbObject::_findBySql('request', $sql, array());
		$this->assign('requests', $requests);
		
		$this->layout = false;
		$this->display('list_body');
	}
	
	public function postSaveFilter($p, $z)
	{
		$filterId = $_POST['id'] ? $_POST['id'] : null;
		$filter = new Filter($filterId);
		if(isset($_POST['name']))
			$filter->name = $_POST['name'];
		$filter->content = json_encode(json_decode($_POST['content'])->subs[0]);
		$filter->save();
		
		echo json_encode(array('id' => $filter->id));
	}
	
	public function pageEdit($p)
	{
		$request = isset($p[1]) && $p[1] ? new Request($p[1]) : new Request();
		$this->assign('request', $request);
	}
	
	public function postEdit($p)
	{
		if($_POST['submitAction'] == 'Save')
		{
			$request = isset($p[1]) && $p[1] ? new Request($p[1]) : new Request();
			$request->setFields(array_merge($_POST['_record'], array('owner_id' => $this->loggedInUser->id)));
			$request->save();
		}
		else if($_POST['submitAction'] == 'Delete')
		{
			assert(isset($p[1]) && $p[1]);
			$request = new Request($p[1]);
			$request->destroy();
		}
		
		$this->redirect('list');
	}
	
	public function pageView($p)
	{
		$file = $p[1];
		$this->assign('filename', $file);
		$this->display('view');
	}
	
	public function postSetField($p, $z)
	{
		$id = $_POST['id'];
		$field = $_POST['field'];
		$request = new Request($id);
		
		if($field == 'completed')
			$request->completed = $_POST['update_value'];
		else if($field == 'priority')
			$request->priority_id = SqlFetchCell("select id from priority where name = :name", array('name' => $_POST['update_value']));
		else
			trigger_error("undefined field: $field");
		
		$request->save();
		
		//	this is sent back and thus placed in the table cell
		echo $_POST['update_value'];
	}
}
