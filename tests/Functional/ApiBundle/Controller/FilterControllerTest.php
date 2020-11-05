<?php

namespace Tests\Functional\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Tests\Functional\ApiBundle\Controller\ApiTestCase;

class FilterControllerTest extends ApiTestCase
{
    public function testFilterAction()
    {
        $response = $this->requestGet('server-information/get-filter-options');
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('storage', $response['data']);
        $this->assertArrayHasKey('ram', $response['data']);
        $this->assertArrayHasKey('hardDiskType', $response['data']);
        $this->assertArrayHasKey('location', $response['data']);
    }

    public function testNotFoundAction()
    {
        $response = $this->requestGet('invalid_url', Response::HTTP_NOT_FOUND);
        $this->assertArrayHasKey('error', $response);
        $this->assertArrayHasKey('code', $response['error']);
        $this->assertArrayHasKey('message', $response['error']);
        $this->assertEquals('error.http.not_found', $response['error']['code']);
    }
}
