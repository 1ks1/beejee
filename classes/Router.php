<?php

class Router
{
    public function run()
    {
        $controllerName = 'HomeController';
        $actionName = 'IndexAction';
        $parameters = [];
        $params['route'] = '';
        if (!empty($_GET)) {
            foreach($_GET as $k=>$v) {
                $params[$k] = trim($v, '/');
            }
        }
        $URIArray = explode('/', $params['route']);
        if (count($URIArray) <= 0 || empty($URIArray[0])) {
            $URIArray = ['Home'];
        };
        if (count($URIArray) > 0) {
            $controllerName = ucfirst(array_shift($URIArray) . 'Controller');
        }
        if (count($URIArray) > 0) {
            $actionName = ucfirst(array_shift($URIArray) . 'Action');
        }
        if (count($URIArray) > 0) {
            $parameters = $URIArray;
        }
        $file = ROOT . '/controllers/' . $controllerName . '.php';
        if (!file_exists($file)) {
            die('<h1> 404 not found controller</h1>');
        }
        $controllerClass = new $controllerName;
        if (method_exists($controllerClass, $actionName))
        {
            call_user_func([$controllerClass, $actionName], $parameters);
        } else {
            die("<h1> 404 not found method</h1>");
        }
    }
}