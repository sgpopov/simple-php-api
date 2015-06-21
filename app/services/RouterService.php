<?php

namespace App\Services;

use App\Middleware\JsonResponseMiddleware as Response;

class RouterService
{
    /**
     * @var string Request type.
     */
    private $method;

    /**
     * @var string Requested URI.
     */
    private $uri;

    /**
     * @var string Requested controller.
     */
    private $controller;

    /**
     * @var string Requested action.
     */
    private $action;

    /**
     * @var array Request arguments.
     */
    private $arguments = [];

    /**
     * @var array List of the allowed HTTP request methods.
     */
    private $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE'];

    public function __construct()
    {
        // Get the current request method.
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);

        // Get the requested URI.
        $this->uri = $_SERVER['REQUEST_URI'];

        // Check if the type of the request is allowed.
        // If it's not - exit with error code 405.
        if (!in_array($this->method, $this->allowedMethods)) {
            return Response::methodNotAllowed($this->method, $this->uri);
        } else {
            // Check if X-HTTP-Method header is added to the POST request
            // and check for validity (either a DELETE or a PUT request).
            if ($this->method === 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
                if ($_SERVER['HTTP_X_HTTP_METHOD'] === 'DELETE') {
                    $this->method = 'DELETE';
                } else {
                    if ($_SERVER['HTTP_X_HTTP_METHOD'] === 'PUT') {
                        $this->method = 'PUT';
                    } else {
                        return Response::methodNotAllowed($this->method, $this->uri);
                    }
                }
            }
        }

        // If it's a put request then add the input add to the arguments.
        if ($this->method === 'PUT') {
            $input = json_decode(file_get_contents('php://input'));

            foreach ($input as $key => $value) {
                $this->arguments[$key] = $value;
            }
        }

        $request = explode('/', $this->uri);

        $this->controller = (count($request) > 1) ? ucwords($request[1] . 'Controller') : null;

        if (count($request) > 2 && $request[2] !== null) {
            if (is_numeric($request[2])) {
                $this->action = null;
                $this->arguments['id'] = $request[2];
            } else {
                $this->action = strtolower($request[2]);
            }
        }

        if (count($request) > 3) {
            $this->arguments['id'] = $request[3];
        }
    }

    /**
     * Register GET requests.
     *
     * @param $url String
     * @param $ctrl_action String
     * @return mixed
     */
    public function get($url, $ctrl_action)
    {
        return $this->validateRoute('GET', $url, $ctrl_action);
    }

    /**
     * Register PUT requests.
     *
     * @param $url String
     * @param $ctrl_action String
     * @return mixed
     */
    public function put($url, $ctrl_action)
    {
        return $this->validateRoute('PUT', $url, $ctrl_action);
    }

    /**
     * Register DELETE requests.
     *
     * @param $url String
     * @param $ctrl_action String
     * @return mixed
     */
    public function delete($url, $ctrl_action)
    {
        return $this->validateRoute('DELETE', $url, $ctrl_action);
    }

    /**
     * Matches the current request against mapped routes.
     *
     * @param $method String - Route's method.
     * @param $url String - Route's URI.
     * @param $requested String - Route's controller and action.
     * @return mixed
     */
    private function validateRoute($method, $url, $requested)
    {
        $req_uri = explode('/', $url);
        $req_action = explode('@', $requested);

        // Compare server request method with route's allowed http methods
        // and server request controller with route's controller
        if ($this->method === $method && $this->controller === $req_action[0]) {

            // check if the requested action is equal to the route's action
            if (preg_match('/^[\w]+$/', $req_uri[2]) && $this->action === $req_uri[2]) {
                return $this->loadAction($this->controller, $req_action[1], $this->arguments);
            } else if (preg_match('/{+(.*?)}/', $req_uri[2]) &&
                $this->action === null && count($this->arguments) > 0) {
                return $this->loadAction($this->controller, $req_action[1], $this->arguments);
            }
        }
    }

    /**
     * Invoke the requested action.
     *
     * @param $controller String
     * @param $action String
     * @param $args Array
     * @return mixed
     */
    private function loadAction($controller, $action, $args) {
        $controller = 'App\\Controllers\\' . $controller;
        $controller = new $controller;

        return $controller->{$action}($args);
    }
}