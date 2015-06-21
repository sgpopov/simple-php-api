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

    public function view()
    {
        
    }

    public function update()
    {
        
    }

    public function delete()
    {

    }
}