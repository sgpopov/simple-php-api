<?php

use App\Services\RouterService as Router;

$router = new Router;

// Jobs
$router->get('/jobs/list', 'JobsController@index');
$router->get('/jobs/{id}', 'JobsController@view');
$router->put('/jobs/{id}', 'JobsController@update');
$router->delete('/jobs/{id}', 'JobsController@delete');

// Candidates
$router->get('/candidates/list', 'CandidatesController@index');
$router->get('/candidates/review/{id}', 'CandidatesController@review');
$router->delete('/candidates/review/{id}', 'CandidatesController@delete');
$router->get('/candidates/search/{id}', 'CandidatesController@search');