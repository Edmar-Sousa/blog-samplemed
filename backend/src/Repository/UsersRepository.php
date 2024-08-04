<?php declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\UserNotFoundException;
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



    public function deleteUserWithId(string $userId)
    {

        $userEntity = $this->findUserWithId($userId);

        if (!$this->usersTable->delete($userEntity))
            throw new ValidationException('Erro ao deletar usuario', $userEntity->getErrors());

        return $userEntity;
    }

    public function updateUserWithId(string $userId, array $userData): User
    {
        $userEntity = $this->findUserWithId($userId);
        $userEntity = $this->usersTable->patchEntity($userEntity, $userData);

        if (!$this->usersTable->save($userEntity))
            throw new ValidationException('Erro ao atualizar usuario', $userEntity->getErrors());

        return $userEntity;
    }


    public function saveUser(array $userData): User
    {
        $userEntity = $this->usersTable->newEntity($userData);

        if (!$this->usersTable->save($userEntity))
            throw new ValidationException('Erro ao cadastrar usuario', $userEntity->getErrors());

        return $userEntity;
    }


    public function getUserWithEmail(string $userEmail): User
    {
        $userEntity = $this->usersTable->find()
            ->where(['email' => $userEmail])
            ->first();

        if (is_null($userEntity)) {
            throw new UserNotFoundException('Usuario com email informado não existe', [
                'email' => 'Email não encontrado',
            ]);

        }


        return $userEntity;
    }
}
