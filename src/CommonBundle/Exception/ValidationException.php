<?php

namespace CommonBundle\Exception;

use MediaMonks\RestApi\Exception\AbstractValidationException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends AbstractValidationException
{
    protected $errors = [];

    /**
     * ValidationException constructor.
     * @param string $message
     * @param string $code
     * @param ConstraintViolationListInterface $violations
     */
    public function __construct($message, $code, ConstraintViolationListInterface $violations)
    {
        foreach ($violations as $violation) {
            $key = substr(
                implode('.',
                    explode('][', $violation->getPropertyPath())
                ), 1, -1
            );

            $violationType = $violation->getConstraint();
            $violationCode = $violation->getCode();

            try {
                $msg = $violationType::getErrorName($violationCode);
            }
            catch (\InvalidArgumentException $e) {
                try {
                    $msg = Collection::getErrorName($violationCode);
                }
                catch (\InvalidArgumentException $e) {
                    $msg = 'UNKNOWN_ERROR';
                }
            }

            $this->errors[$key] = $msg;
        }

        parent::__construct($message, $code);
    }

    public function getFields()
    {
        return $this->errors;
    }

    public function toArray(): array
    {
        $return = [
            'code'      => $this->getCode(),
            'message'   => $this->getMessage(),
            'errors'    => $this->getFields()
        ];

        return $return;
    }
}