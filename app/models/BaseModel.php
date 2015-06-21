<?php

namespace App\Models;

use App\Services\DatabaseService as DB;

class BaseModel
{
    /**
     * @var DB DatabaseService - Instance of the DB Service.
     */
    private $db;

    /**
     * @var String - SQL query which will be executed.
     */
    protected $query;

    /**
     * @var Array - Addition params which will be bind.
     */
    protected $params = [];

    public function __construct()
    {
        $this->db = DB::instance();
    }

    /**
     * Public help function that will execute the query.
     *
     * @return mixed
     */
    public function query()
    {
        $result = $this->db->prepare($this->query);
        $result->execute($this->params);

        return $result;
    }
}