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
     * Retrieve all candidates from the database.
     *
     * @return Array - All candidates.
     */
    public function all()
    {
        // Get all users who have applied for a job
        $this->query = ''.
            'SELECT users.* ' .
            'FROM users ' .
            'INNER JOIN candidates ON candidates.user_id = users.id ' .
            'GROUP BY users.id';

        $candidates = $this->query()->fetchAll();

        $output = [];

        // Get the jobs information for every user application.
        foreach ($candidates as $candidate) {
            array_push($output, $candidate);
            $outputLastIndex = count($output) - 1;

            $this->query = ''.
                'SELECT '.
                    'jobs.id as job_id, jobs.position, jobs.description, '.
                    'candidates.id as candidate_id, candidates.created_on as applied_on '.
                'FROM jobs '.
                'INNER JOIN candidates ON candidates.job_id = jobs.id '.
                'WHERE candidates.user_id = :user_id';
            $this->params['user_id'] = $candidate['id'];

            // Create nested "Jobs" property for the user.
            $output[$outputLastIndex]['jobs'] = $this->query()->fetchAll();
        }

        return $output;
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