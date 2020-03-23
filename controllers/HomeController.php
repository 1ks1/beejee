<?php

class HomeController extends Controller
{
    function indexAction($parameters)
    {
		$this_page = 1;
		$token = 0;
		if (!empty($_SESSION['token'])) {
			$token = $_SESSION['token'];
		}
		if (!empty($_SESSION['page'])) {
			$this_page = $_SESSION['page'];
		}
		if (is_array($parameters) && count($parameters) > 0) {
			$this_page = array_shift($parameters);
		}
		if (!empty($_POST['page'])) {
			$this_page = $_POST['page'];
			$_SESSION['page'] = $this_page;
		}
		$data =[];
		$sort = $this->setSort();
		$r = $this->model->tasks($this_page, $sort);
		$data['result'] = $r;
		$data['username'] = 'Guest';
		$data['email'] = '';
		$data['options'] = '';
		$data['log_button'] = '<a href="/login/">login</a>';

		if (!empty($_SESSION['userName'])) {
			$data['username'] = $_SESSION['userName'];
			$data['log_button'] = '<a href="/login/logout/' . 
				$_SESSION['token'] .
				'">logout</a>';
			$login = new LoginController;
			$data['admin'] = false;
			if ($login->isAdmin()) {
				$data['admin'] = true;
			}

			$data['admin'] = $login->isAdmin();
			$data['options'] = '<button>edit</button>';
		}

		$data['htmlTableBody'] = $this->view->generateTable($data);
		$data['htmlButtonToolbar'] = $this->view->generateToolBar($data);
		$this->view->show('templates/header.php');
		$this->view->show('templates/index.php', $data);
		$this->view->show('templates/footer.php');
	}

	function setSort()
	{
		$sort = 'username';
		if (!empty($_SESSION['sort'])) {
			$sort = $_SESSION['sort'];
		}

		if (!empty($_POST['sort']) && $_POST['sort'] == 'username') {
			if (!empty($_SESSION['sort']) and $_SESSION['sort'] == 'username DESC') {
				$_SESSION['sort'] = 'username ASC';
			} else {
				$_SESSION['sort'] = 'username DESC';
			}
			if (empty($_SESSION['sort'])) {
				$_SESSION['sort'] = 'username ASC';
			}
			$sort = $_SESSION['sort'];
		}

		if (!empty($_POST['sort']) && $_POST['sort'] == 'email') {
			if (!empty($_SESSION['sort']) and $_SESSION['sort'] == 'email DESC') {
				$_SESSION['sort'] = 'email ASC';
			} else {
				$_SESSION['sort'] = 'email DESC';
			}
			if (empty($_SESSION['sort'])) {
				$_SESSION['sort'] = 'email ASC';
			}
			$sort = $_SESSION['sort'];
		}

		if (!empty($_POST['sort']) && $_POST['sort'] == 'status') {
			if (!empty($_SESSION['sort']) and $_SESSION['sort'] == 'status DESC') {
				$_SESSION['sort'] = 'status ASC';
			} else {
				$_SESSION['sort'] = 'status DESC';
			}
			if (empty($_SESSION['sort'])) {
				$_SESSION['sort'] = 'status ASC';
			}
			$sort = $_SESSION['sort'];
		}
		return $sort;
	}

	function addAction()
	{
		$res = 'ADD WORKS ...';
		if (!empty($_POST['username'] && $_POST['text'] && $_POST['email'])) {
			$res = 'OK';
			$userName = trim($_POST['username']);
			$text = trim($_POST['text']);
			$email = trim(strtolower($_POST['email']));
			if (strlen($text) < 3) {
				$res = 'ERROR: TASK TEXT TOO SHORT';
			}

			if (!$this->model->validate('username', $userName)) {
				$res = 'ERROR: USERNAME';
			}
			if (!$this->model->validate('email', $email)) {
				$res = 'ERROR: EMAIL';
			}
			$text = $this->model->validate('text', $text);

			if ($res == 'OK') {
				$data = [
					'username' => $userName,
					'email' => $email,
					'text' => $text
				];
				$res = $this->model->insertTask($data);
			}
			
		} else {
			$res = 'ERROR: EMPTY ONE OR MORE FIELDS';
		}
		echo $res;
	}

	function checkAction($params)
	{
		$res = 'CHECKING ...';
		$id = array_shift($params);
		$token = array_shift($params);
		if (empty($token) || strlen($token) != 32) {
			die('ERROR: LOGIN');
		}
		if (!UsersModel::chekAdmin($token)) {
			die('ERROR: PERMISSION C');
		}
		if (!is_numeric($id)) {
			die('ERROR: ID');
		}
		$res = $this->model->setCheckTask($id, $token);
		echo $res;
	}

	function editAction()
	{
		$res = 'EDITING ...';
		if (!empty($_POST['token'] && $_POST['text'] && $_POST['id'])) {
			$token = $_POST['token'];
			if (empty($token) || strlen($token) != 32) {
				die('ERROR: LOGIN');
			}
			if (!UsersModel::chekAdmin($token)) {
				die('ERROR: PERMISSION C');
			}
			$id = trim($_POST['id']);
			if (!is_numeric($id)) {
				die('ERROR: ID MUST NUMERIC');
			}
			$text = trim($_POST['text']);
			if (strlen($text) < 3) {
				die('ERROR: TASK TEXT TOO SHORT');
			}
			if (strlen($text) > 200) {
				die('ERROR: MAX 200 CHARS');
			}
			$text = $this->model->validate('text', $text);
			$status = $this->model->readTask($id)[0]['status'];
			switch ($status) {
				case 'new': 
					$newStat = 'edited';
					break;
				case 'edited': 
					$newStat = 'edited';
					break;
				case 'done': 
					$newStat = 'done_edited';
					break;
				case 'done_edited': 
					$newStat = 'done_edited';
					break;
			}
			$data = [
				'id' => $id,
				'tasktext' => $text,
				'status' => $newStat,
				'token' => $token
			];
			$res = $this->model->updateTask($data);

		} else {
			die('ERROR: (TASK TEXT | LOGIN)');
		}

		echo $res;
	}

}