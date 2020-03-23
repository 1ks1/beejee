<?php

class Model
{
    public static $pdo;
    public function __construct()
    {
        self::$pdo = Db::connect();
    }

    public function tasks($page = 1, $sort = 'username')
    { 
        if (!is_numeric($page)) {
            $page = 1;
        }
        $limit = 'LIMIT 0,3';
        $limitRes = $this->getLimit($page);
        $thePage['allPages'] = ceil( $limitRes['allPages'] / 3 );
        if ($page < 1 || $page > $thePage['allPages']) {
            $page = 1;
        }
        $sql = 'SELECT tasks.id taskID,tasks.status status, tasks.tasktext tasktext, ' . 
        'users.username username, users.email email ' .
        'FROM tasks, users ' .
        'WHERE users.id = tasks.userID ' . 
        'ORDER BY ' . $sort . ' ' . 
        $limitRes['limit'];
        $stmt = self::$pdo->prepare($sql);
        $result = $stmt->execute();
        $res = $stmt->fetchAll();
        $thePage['taskData'] = $res;
        $thePage['pageNumber'] = $page;
        return $thePage;
    }

    function getLimit($pageNumber)
    {
        $sql = 'SELECT count(*) FROM tasks';
        $stmt = self::$pdo->prepare($sql);
        $result = $stmt->execute();
        $allItemsCount = $stmt->fetchAll()[0]['count(*)'];
        $offset = ceil($pageNumber * 3) - 3;
		if ($allItemsCount < $offset) {
				$offset = 0;
        }
		return ['limit' => "LIMIT $offset,3", 'allPages' => $allItemsCount];
    }

    function validate($validate_type, $str)
    {
        $res = false;
        switch($validate_type) {
            case 'text':
                $res = htmlspecialchars($str);
                break;
            case 'email':
                if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
                    $res = true;
                }
                break;
            case 'username':
                    if (preg_match("/^[a-zA-Z]*_?[a-zA-Z0-9]*$/", $str) && strlen($str) > 2) {
                        $res = true;
                    }
                break;
        }
        return $res;
    }

    function insertTask($data)
    {
        $res = 'DB ERROR';
        $usersModel = new UsersModel; 
        $user = $usersModel->getUserByEmail($data['email']);
        if (!empty($user)) {
            if ($user[0]['email'] == ADMIN_EMAIL) {
                $res = 'YOU ARE NOT ADMIN';
                return $res;
            }
            $data['username'] = $user[0]['username'];
            $data['userID'] = $user[0]['id'];
        } else {
            $sql = "INSERT INTO `users`(`username`, `email`, `role`, `password`) " . 
                "VALUES ('" . $data['username'] . "','" . $data['email'] . "', 'user', '" .
                md5(12345678). "')";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute();
            $sql = "SELECT LAST_INSERT_ID()";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll()[0]['LAST_INSERT_ID()'];
            $data['userID'] = $res;
        }

        $sql = "INSERT INTO `tasks`(`status`, `tasktext`, `userID`) VALUES ('new','" .
            $data['text'] ."'," . 
            $data['userID'] . ")";
        $stmt = self::$pdo->prepare($sql);
        if ($stmt->execute()) {
            $res = 'OK';
        }
        return $res;
    }

    function updateTask($data)
    {
        if (empty($data['id'])) {
            return 'ERROR: HAVE NO ID';
        }
        $id = $data['id'];
        unset($data['id']);
        $token = $data['token'];
        unset($data['token']);
        if (!UsersModel::chekAdmin($token)) {
            return 'ERROR: PERMISSION M';
        }
        unset($data['token']);
        $arr = [];
        foreach ($data as $k => $v) {
            if (is_numeric($v)) {
                $arr[] = "$k = $v";
            } else {
                $arr[] = "$k = '$v'";
            }
        }
        $set = implode(',', $arr);
        $sql = 'UPDATE `tasks` SET ' . $set . ' WHERE id=' . $id;
        $stmt = self::$pdo->prepare($sql);
        if ($stmt->execute()) {
            return 'OK';
        }
        return 'UNCNOWN ERROR M';
    }

    function setCheckTask($id, $token)
    {
        if (!UsersModel::chekAdmin($token)) {
			return 'ERROR: PERMISSION M';
        }
        $status = $this->readTask($id)[0]['status'];
        switch ($status) {
            case 'new': $newStat = 'done';
                break;
            case 'edited': $newStat = 'done_edited';
                break;
            case 'done': $newStat = 'done';
                break;
            case 'done_edited': $newStat = 'done_edited';
                break;
            default:
                $newStat = 'new';
                break;
        }
        if (empty($status)) {
            $newStat = 'new';
        }
        $data = [
            'id' => $id,
            'status' => $newStat,
            'token' => $token
        ];
        if ($this->updateTask($data)) {
            return 'OK';
        }
        return 'OK';
    }

    function readTask($id)
    {
        if (empty($id)) {
            return 'ERROR: HAVE NO ID';
        }
        $sql = 'SELECT * FROM `tasks` WHERE id=' . $id;
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

}