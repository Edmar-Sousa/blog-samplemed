<?php declare(strict_types=1);

namespace App\Repository;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use App\Exceptions\ValidationException;



class UsersRepository
{
    protected UsersTable $usersTable;

    public function __construct(UsersTable $usersTable)
    {
        $this->usersTable = $usersTable;
    }



    public function findUserWithId(string $userId): User
    {
        return $this->usersTable->get($userId);
    }


    public function saveUser(array $userData): User
    {
        $userEntity = $this->usersTable->newEntity($userData);

        if (!$this->usersTable->save($userEntity))
            throw new ValidationException('Erro ao cadastrar usuario', $userEntity->getErrors());

        return $userEntity;
    }
}
