<?php

namespace App\Core;

use App\Core\Database;

abstract class Model
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
}
