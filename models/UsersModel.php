<?php

class UsersModel
{

    function login($userEmail, $password)
    {
        $result = false;
        $pdo = DB::connect();
        $password = md5($password);
        $sql = "SELECT * FROM `users` WHERE email='$userEmail' and '$password'";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                $result = $result[0];
                $userToken = md5(time() . $result['password']);
                $this->setToken($userEmail, $password, $userToken);
                $result['token'] = $userToken;
            }
        };
        return $result;
    }

    function setToken($userEmail, $password, $userToken) 
    {
        $result = false;
        $sql = "UPDATE `users` SET `token`='$userToken' WHERE `email`='$userEmail' and `password`='$password'";
        $stmt = Model::$pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }

    function getUserByEmail($email)
    {
        $res = false;
        $sql = "SELECT * from users where email='$email'";
        $stmt = Model::$pdo->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }
    
    static function chekAdmin($token)
    {
        $res = false;
        $sql = "SELECT count(email) FROM users WHERE email ='admin' " .
            " AND token='$token'";
        $stmt = Model::$pdo->prepare($sql);
        $result = $stmt->execute();
        $count = $stmt->fetchAll()[0]['count(email)'];
        if ($count == 1) {
            $res = true;
        }
        return $res;
    }

    function logout($token)
    {
        $sql = "UPDATE `users` SET token='0' WHERE token='$token'";
        $stmt = Model::$pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }
}