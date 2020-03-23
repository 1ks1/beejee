<?php

class LoginController extends Controller
{
    public function indexAction()
    {
        $data['message'] = 'please login';

        if (empty($_SESSION['login'])) {
            $data['login'] = '';
        } else {
            $data['login'] = $_SESSION['login'] ;
        }

        if (isset($_POST['btn_login'])) {
            $_SESSION['login'] = $_POST['login'];
            $usersModel = new UsersModel;
            $userEmail = $_POST['login'];
            $password = $_POST['password'];
            $result = $usersModel->login($userEmail, $password);
            if (is_array($result) and count($result) > 0) {
                $userData = $result;
                $_SESSION['token'] = $result['token'];
                $_SESSION['userName'] = $result['username'];
                setcookie('token', $result['token'], time()+(3600*10), '/');
                setcookie('userName', $result['username'], time()+(3600*10), '/');
                header('Location: /home');
            } else {
                $data['message'] = 'wrong login or password';
                setcookie('token', '', time() - 100, '/');
                setcookie('userName','Guest', time() - 100, '/');
            }
        }
        $this->view->show('templates/header.php', $data);
        $this->view->show('templates/login.php', $data);
        $this->view->show('templates/footer.php', $data);
    }

    function logoutAction($token = [])
    {
        $token = $token[0];
        setcookie('PHPSESSID', '', time() - 100, '/');
        setcookie('token', '', time() - 100, '/');
        setcookie('userName', '', time() - 100, '/');
        unset($_SESSION['token']);
        unset($_SESSION['userName']);
        unset($_SESSION['login']);
        $usersModel = new UsersModel;
        $usersModel->logout($token);
        header('Location: /home');
    }

    function isAdmin()
    {
        $res = false;
        if (empty($_SESSION['token'])) {
            return false;
        } else {
            $token = $_SESSION['token'];
            $res = UsersModel::chekAdmin($token);
        }
        return $res;
    }
}