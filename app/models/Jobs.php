<?php

namespace App\Models;

class Jobs extends BaseModel
{
    private $validation_log = [];

    /**
     * Retrieve all jobs from the database.
     *
     * @return Array - All jobs.
     */
    public function all()
    {
        $this->query = 'SELECT id, position, description FROM jobs';

        return $this->query()->fetchAll();
    }

    /**
     * Retrieve job information by given ID.
     *
     * @param $job_id Integer - Given job id.
     * @return Array - Job information
     */
    public function findBy($job_id)
    {
        // validate the given ID.
        $this->validate(['id' => $job_id]);

        // return validation error if the given ID is not valid.
        if (count($this->validation_log) > 0) {
            return ['validation', $this->validation_log];
        }

        $this->query = "SELECT * FROM jobs WHERE id = :job_id";
        $this->params = [
            ':job_id' => $job_id
        ];

        $job = $this->query()->fetchAll($this->fetch_mode);

        // return empty array if there are no jobs.
        if (count($job) < 1) {
            return [];
        }

        // fetch all candidates for the given job.
        $candidates = new Candidates;
        $job[0]['candidates'] = $candidates->findByJobId($job_id);

        return $job;
    }

    /**
     * Help function that check if the given args are valid:
     *  - ID: should be an integer
     *  - Position: Should contain only alphabets (a-z, A-Z), spaces and dashes.
     *  - Description: Should contain only alphabets (a-z, A-Z), numbers (0-9), spaces and dashes.
     */
    private function validate()
    {
        $args = func_get_args();

        // If an ID is passed it should be a number.
        if (isset($args['id']) && filter_var($args['id'], FILTER_VALIDATE_INT)) {
            array_push($this->validation_log, [
                'error' => [
                    'param' => 'id',
                    'message' => 'The job ID should be integer'
                ]
            ]);
        }

        // Validate position data if it is passed.
        if (isset($args['position']) && !preg_match('/^[A-Za-z\s-_]+$/', $args['position'])) {
            array_push($this->validation_log, [
                'error' => [
                    'param' => 'position',
                    'message' => 'The position should contain only alphabets, spaces and dashes.'
                ]
            ]);
        }

        // Validate position data if it is passed.
        if (isset($args['description']) && !preg_match('/^[0-9A-Za-z\s-_]+$/', $args['description'])) {
            array_push($this->validation_log, [
                'error' => [
                    'param' => 'description',
                    'message' => 'The description should contain only alphabets, spaces and dashes.'
                ]
            ]);
        }
    }
}