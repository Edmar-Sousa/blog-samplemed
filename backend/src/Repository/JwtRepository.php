<?php declare(strict_types=1);

namespace App\Repository;

use Firebase\JWT\JWT;
use App\Exceptions\InvalidPasswordException;
use Authentication\PasswordHasher\DefaultPasswordHasher;


class JwtRepository
{

    protected string $key;
    protected DefaultPasswordHasher $passwordHasher;


    public function __construct(string $key)
    {
        $this->passwordHasher = new DefaultPasswordHasher();
        $this->key = $key;
    }



    public function check(string $password, string $passwordHashed)
    {
        if (!$this->passwordHasher->check($password, $passwordHashed)) {
            throw new InvalidPasswordException('Senha incorreta', [
                'password' => 'Senha incorreta',
            ]);

        }
    }



    public function generateToken(string $userId)
    {
        $payload = [
            'sub' => '45afcfab-1bbe-469b-a766-be7203d12839',
            'exp' => time() + 3600
        ];


        return JWT::encode($payload, $this->key, 'HS256');
    }

}