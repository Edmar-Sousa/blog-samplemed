<?php
declare(strict_types=1);

namespace App\Controller;

use Firebase\JWT\JWT;
use Cake\View\JsonView;

class AuthController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }



    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function login()
    {
        $requestData = $this->request->getData();

        $email = $requestData['email'];
        $password = $requestData['password'];


        $key = '1289012najhsdka1789371njshd7d2juh';
        $payload = [
            'sub' => '45afcfab-1bbe-469b-a766-be7203d12839',
            'exp' => time() + 3600
        ];


        $token = JWT::encode($payload, $key, 'HS256');


        $this->set('token', $token);
        $this->viewBuilder()->setOption('serialize', ['token']);
    }
}
