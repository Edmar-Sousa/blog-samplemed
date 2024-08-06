<?php declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UserNotFoundException;
use App\Repository\UsersRepository;


class UserService
{
    protected UsersRepository $userService;

    public function __construct(UsersRepository $userService)
    {
        $this->userService = $userService;
    }


    public function checkIdUserLogged(string|null $userId)
    {
        // TODO procurar no banco de dados
        if (is_null($userId))
            throw new UserNotFoundException('Token de usuario não existe');
    }

}

