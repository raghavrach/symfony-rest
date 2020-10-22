<?php

namespace Tests\Functional\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class provides the basic setup and also GET and POST requests.
 */
class ApiTestCase extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected static $client;

    public function setUp(){
        self::$client = static::createClient();
    }

    /**
     * @param $path
     * @param int $httpCode
     * @param array $headers
     * @param string $message
     * @return mixed
     */
    protected function requestGet($path, $httpCode = Response::HTTP_OK, $headers = [], $message = '')
    {
        return $this->request(Request::METHOD_GET, $path, [], $httpCode, $headers, $message);
    }

    /**
     * @param $path
     * @param array $data
     * @param int $httpCode
     * @param array $headers
     * @param string $message
     * @return mixed
     */
    protected function requestPost($path, $data = [], $httpCode = Response::HTTP_CREATED, $headers = [], $message = '')
    {
        return $this->request(Request::Method_POST, $path, $data, $httpCode, $headers, $message);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $data
     * @param int $httpCode
     * @param array $headers'
     * @param string $message
     * @return mixed
     */
    protected function request($method, $path, array $data = [], $httpCode = Response::HTTP_OK, $headers = [], $message = '')
    {
        self::$client->request($method, sprintf('/%s', $path), $data, [], $headers, $message);
        $response = self::$client->getResponse();

        $this->assertEquals($httpCode, $response->getStatusCode(), $message . PHP_EOL. $response->getContent());
        $content = json_decode(self::$client->getResponse()->getContent(), true);

        return $content;
    }
}
