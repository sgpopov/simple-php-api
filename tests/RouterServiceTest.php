<?php

require '../vendor/autoload.php';

class RouterServiceTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'http://simple-api.local'
        ]);
    }

    public function test_shouldProcessGETRequests()
    {
        $response = $this->client->get('/jobs/list');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['application/json'], $response->getHeader('Content-Type'));

        $response = $this->client->get('/jobs/2');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['application/json'], $response->getHeader('Content-Type'));
    }


    public function test_shouldProcessPUTRequests()
    {
        $obj = [
            'position' => 'test',
            'description' => 'test'
        ];

        $response = $this->client->put('/jobs/2', [
            'json' => $obj
        ]);

        // Successfully updated
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals(['application/json'], $response->getHeader('Content-Type'));

        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Successfully updated 1 record(s)', $data['message']);

        $response = $this->client->put('/jobs/2', [
            'json' => $obj
        ]);

        // Nothing to update
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals(['application/json'], $response->getHeader('Content-Type'));
    }

    public function test_shouldHandlePATCHRequestsProperly()
    {
        $response = $this->client->patch('/jobs/1', ['http_errors' => false]);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertEquals(['application/json'], $response->getHeader('Content-Type'));

        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Method Not Allowed', $data['error']);
        $this->assertEquals('The requested method PATCH is not allowed for the URL /jobs/1.', $data['message']);
    }
}
