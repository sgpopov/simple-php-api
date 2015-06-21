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

    public function index()
    {
        $output = $this->candidates->all();

        return Response::success($output);
    }

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
}