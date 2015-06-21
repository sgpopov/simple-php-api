<?php

namespace App\Models;

class Candidates extends BaseModel
{
    private $validation_log = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retrieve all candidates for a given job by it's id.
     *
     * @param $job_id Integer - Given job id.
     * @return Array
     */
    public function findByJobId($job_id)
    {
        $this->query = "" .
            "SELECT cnd.id, usr.first_name, usr.last_name, usr.email, cnd.created_on " .
            "FROM candidates cnd " .
            "INNER JOIN users usr ON usr.id = cnd.user_id " .
            "WHERE cnd.job_id = :job_id";

        $this->params = [
            ':job_id' => $job_id
        ];

        return $this->query()->fetchAll($this->fetch_mode);
    }

}