<?php

namespace CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Monolog\Logger;

/**
 * This is the base class which will be extended by all the controllers
 * Common controller properties and methods will be defined here
 *
 * BaseController constructor.
 * @param Logger $logger
 */
class BaseController extends Controller
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Created the following constructor to handle Logger Dependencies
     *
     * BaseController constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
}