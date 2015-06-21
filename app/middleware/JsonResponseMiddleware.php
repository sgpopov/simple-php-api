<?php

namespace App\Middleware;

use App\App as App;

class JsonResponseMiddleware
{
    public function __construct() { }

    /**
     * @param $code Integer - HTTP status code.
     * @return mixed String - HTTP status.
     */
    private static function statusCodes($code)
    {
        $status = [
            200 => 'OK',
            201 => 'Created',
            204 => 'No Content',
            400 => 'Bad Request',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        ];

        return ($status[$code]) ? $status[$code] : $status[500];
    }

    /**
     * Set response headers.
     *
     * @param $code Integer - HTTP status code.
     */
    private static function setHeaders($code)
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 '. $code .' '. self::statusCodes($code), true, $code);
    }

    /**
     * Render success response.
     *
     * @param $data Array - The data to be displayed.
     */
    public static function success($data)
    {
        self::setHeaders(200);

        echo json_encode($data, App::instance()->config['json_options']);
        exit;
    }

    /**
     * Render successfully updated resource response.
     *
     * @param $data Array - The data to be displayed.
     */
    public function updated($data)
    {
        self::setHeaders(201);

        echo json_encode($data, App::instance()->config['json_options']);
        exit;
    }

    /**
     * Render no content.
     */
    public static function noContent()
    {
        self::setHeaders(204);
        exit;
    }

    /**
     * Render "Bad Request" response (validation error).
     *
     * @param $data Array - The data to be displayed.
     */
    public static function badRequest($data)
    {
        self::setHeaders(400);

        echo json_encode($data, App::instance()->config['json_options']);
        exit;
    }

    /**
     * Render "Method Not Allowed" error response.
     *
     * @param $method String - Requested method
     * @param $url String - Requested URI.
     */
    public static function methodNotAllowed($method, $url)
    {
        self::setHeaders(405);

        $errorMessage = [
            'error' => 'Method Not Allowed',
            'message' => 'The requested method '. $method . ' is not allowed for the URL '. $url .'.'
        ];

        echo json_encode($errorMessage, App::instance()->config['json_options']);
        exit;
    }
}