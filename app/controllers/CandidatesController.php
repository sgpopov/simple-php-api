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
}