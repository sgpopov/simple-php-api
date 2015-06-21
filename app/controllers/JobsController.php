<?php
namespace App\Controllers;

use App\Models\Jobs as Jobs;
use App\Middleware\JsonResponseMiddleware as Response;

class JobsController
{
    /**
     * @var Jobs - instance of the Jobs model.
     */
    private $jobs;

    public function __construct()
    {
        $this->jobs = new Jobs;
    }

    /**
     * View all jobs.
     *
     * @api GET /jobs/list - Retrieve all jobs.
     * @apiExample Example CURL usage
     *      curl -i http://localhost/jobs/list
     */
    public function index()
    {
        return Response::success($this->jobs->all());
    }

    /**
     * View a job by given id.
     *
     * @api GET /jobs/:id - Request job's information.
     * @apiParam Integer id - Job id.
     * @apiExample Example CURL usage
     *      curl -i http://localhost/jobs/1
     *
     * @param $args Array
     */
    public function view($args)
    {
        // return bad request response if there is not an ID passed.
        if (!isset($args['id'])) {
            return Response::badRequest([
                'message' => 'Missing job id.'
            ]);
        }

        $output = $this->jobs->findBy($args['id']);

        // return bad request response if there are some kind of a validation errors
        if (isset($output['error']) && $output['error'] === 'validation') {
            return Response::badRequest($output['data']);
        }

        // return no content response if there are no records for a job
        if (count($output) < 1) {
            return Response::noContent();
        }

        return Response::success($output);
    }

    /**
     * Update job's information.
     *
     * @api PUT /jobs/:id - Modify job's information.
     * @apiParam Integer id - Job id.
     * @apiExample Example CURL usage
     *      curl -i \
     *          --header "Content-type: application/json" \
     *          --request PUT \
     *          --data '{"position": "test position", "description": "simple description"}' \
     *          http://localhost/jobs/1
     *
     * @param $args Array
     */
    public function update($args)
    {
        // return bad request response if there is not an ID passed.
        if (!isset($args['id'])) {
            return Response::badRequest([
                'message' => 'Missing job id.'
            ]);
        }

        $output = $this->jobs->update($args);

        // return bad request response if there are validation errors
        if (isset($output['error']) && $output['error'] === 'validation') {
            return Response::badRequest($output['data']);
        }

        // return no content response if there are no records for a job
        if ($output === 0) {
            return Response::noContent();
        }

        return Response::updated([
            'message' => 'Successfully updated '. $output .' record(s)'
        ]);
    }

    /**
     * Delete a job by given id.
     * Note: This will also delete all candidates applied for the job.
     *
     * @api DELETE /jobs/:id - Delete job.
     * @apiParam Integer id - Job id..
     * @apiExample Example CURL usage
     *      curl -i --request DELETE http://localhost/jobs/1
     *
     * @param $args Array
     */
    public function delete($args)
    {
        // return bad request response if there is not an ID passed.
        if (!isset($args['id'])) {
            return Response::badRequest([
                'message' => 'Missing job id.'
            ]);
        }

        $output = $this->jobs->delete($args);

        // return bad request response if there are validation errors
        if (isset($output['error']) && $output['error'] === 'validation') {
            return Response::badRequest($output['data']);
        }

        // return no content response if there are no records for a job
        if ($output === 0) {
            return Response::noContent();
        }

        return Response::success([
            'message' => 'Successfully deleted '. $output .' record(s)'
        ]);
    }
}