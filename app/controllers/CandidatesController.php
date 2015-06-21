<?php

namespace App\Controllers;

use App\Models\Candidates;
use App\Middleware\JsonResponseMiddleware as Response;

class CandidatesController
{
    private $candidates;

    public function __construct()
    {
        $this->candidates = new Candidates;
    }

    /**
     * List of all users with their corresponding job applications.
     *
     * @api GET /candidates/list
     * @apiExample Example CURL usage
     *      curl -i http://localhost/candidates/list
     *
     */
    public function index()
    {
        $output = $this->candidates->all();

        return Response::success($output);
    }

    /**
     * Retrieve job's application information by given id.
     *
     * @api GET /candidates/review/:id - Get job's application
     * @apiParam Integer id - Job's application id.
     * @apiExample Example CURL usage
     *      curl -i http://localhost/candidates/review/1
     *
     * @param $args Array
     */
    public function review($args)
    {
        // return bad request response if there is not an ID passed.
        if (!isset($args['id'])) {
            return Response::badRequest([
                'message' => 'Missing application id.'
            ]);
        }

        $output = $this->candidates->review($args['id']);

        // return bad request response if there are some kind of a validation errors
        if (isset($output['error']) && $output['error'] === 'validation') {
            return Response::badRequest($output['data']);
        }

        // return no content response if there are no records for the job application
        if (count($output) < 1) {
            return Response::noContent();
        }

        return Response::success($output);
    }

    /**
     * Delete job's application by given id.
     *
     * @api DELETE /candidates/review/:id
     * @apiParam Integer id - Job's application id.
     * @apiExample Example CURL usage
     *      curl -i --request DELETE http://localhost/candidates/review/1
     *
     * @param $args Array
     */
    public function delete($args)
    {
        // return bad request response if there is not an ID passed.
        if (!isset($args['id'])) {
            return Response::badRequest([
                'message' => 'Missing job application id.'
            ]);
        }

        $output = $this->candidates->delete($args['id']);

        // return bad request response if there are validation errors
        if (isset($output['error']) && $output['error'] === 'validation') {
            return Response::badRequest($output['data']);
        }

        // return no content response if there are no records for the job application
        if ($output === 0) {
            return Response::noContent();
        }

        return Response::success([
            'message' => 'Successfully deleted '. $output .' record(s)'
        ]);
    }

    /**
     * Search for job's application(s) by given id.
     *
     * @api GET /candidates/search/:id
     * @apiParam Integer id - Job's application id.
     * @apiExample Example CURL usage
     *      curl -i --request GET http://localhost/candidates/search/1
     *
     * @param $args Array
     */
    public function search($args)
    {
        // return bad request response if there is not an ID passed.
        if (!isset($args['id'])) {
            return Response::badRequest([
                'message' => 'Missing application id.'
            ]);
        }

        $output = $this->candidates->search($args['id']);

        // return bad request response if there are some kind of a validation errors
        if (isset($output['error']) && $output['error'] === 'validation') {
            return Response::badRequest($output['data']);
        }

        // return no content response if there are no records for the job application
        if (count($output) < 1) {
            return Response::noContent();
        }

        return Response::success($output);
    }
}