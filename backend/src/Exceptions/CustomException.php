<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;


class CustomException extends Exception
{
    protected array $errors;

    public function __construct($message, $errors = [])
    {
        parent::__construct($message);
        $this->errors = $errors;
    }


    public function getErrorsMessage(): array
    {
        return $this->errors;
    }
}


