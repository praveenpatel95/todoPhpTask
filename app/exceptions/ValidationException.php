<?php
namespace Exceptions;
use Exception;
class ValidationException extends Exception
{
    private array $errors;

    /**
     * @param $message
     */
    public function __construct($message)
    {
        if (is_array($message)) {
            $this->errors = $message;
            $message = json_encode($message);
        } else {
            $this->errors = [$message];
        }

        parent::__construct($message, 422);
    }

    /**
     * @return array
     */
    public function getValidationErrors(): array
    {
        return $this->errors;
    }
}