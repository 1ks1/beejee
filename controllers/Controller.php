<?php

class Controller
{
    protected $model;
    protected $view;

    function __construct()
    {
        $this->model = new Model;
        $this->view = new View;
    }
}