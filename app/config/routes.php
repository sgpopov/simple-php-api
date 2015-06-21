<?php

use App\Services\RouterService as Router;

$router = new Router;

// Jobs
$router->get('/jobs/list', 'JobsController@index');
$router->get('/jobs/{id}', 'JobsController@view');
$router->put('/jobs/{id}', 'JobsController@update');
$router->delete('/jobs/{id}', 'JobsController@delete');
