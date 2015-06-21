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

    public function index()
    {
        return Response::success($this->jobs->all());
    }

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