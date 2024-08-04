<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;


class UserNotFoundException extends Exception
{

    protected array $errors;

    public function __construct(string $message, $errors)
    {
        parent::__construct($message);

        $this->errors = $errors;
    }



    public function getErrorsMessages()
    {
        return $this->errors;
    }

}
