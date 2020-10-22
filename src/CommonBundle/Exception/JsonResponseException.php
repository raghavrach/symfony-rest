<?php
namespace CommonBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Custom JSON Response Exception
 */
class JsonResponseException extends HttpException
{
    /**
     * Constructor Function
     *
     * @param $message - Exception message
     * @param $statusCode - HTTP status code
     * @param $headers - Response headers
     */
    public function __construct(string $message = NULL, int $statusCode = 500, array $headers = [])
    {
        # Call parent constructor
        parent::__construct($statusCode, $message, null, $headers);
    }
}
