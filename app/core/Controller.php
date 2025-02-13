<?php

namespace App\Core;

abstract class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);
        include_once __DIR__ . "/../views/$view.php";
    }
}