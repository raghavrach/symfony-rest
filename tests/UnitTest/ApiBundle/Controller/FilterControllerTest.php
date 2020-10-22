<?php

namespace Tests\UnitTest\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ApiBundle\Controller\FilterController;
use Monolog\Logger;

class FilterControllerTest extends WebTestCase
{
    public function testFilterMethod()
    {
        $request = $this->getMock("Symfony\Component\HttpFoundation\Request");
        $container = $this->getMock("Symfony\Component\DependencyInjection\ContainerInterface");
        $service = $this->getMockBuilder("ApiBundle\Service\Filter")->disableOriginalConstructor()->getMock();


        $container->expects($this->once())
            ->method("get")
            ->with($this->equalTo('api.services.filter'))
            ->will($this->returnValue($service));

        $this->logger = new Logger();
        $controller = new FilterController($this->logger);
        $controller->setContainer($container);

        $controller->goAction($request);

    }
}