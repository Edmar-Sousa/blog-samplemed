<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\UserNotFoundException;
use Exception;
use Firebase\JWT\JWT;
use Cake\View\JsonView;
use Cake\ORM\TableRegistry;
use App\Repository\JwtRepository;
use App\Repository\UsersRepository;
use App\Exceptions\InvalidPasswordException;

class AuthController extends AppController
{


    protected UsersRepository $usersRepository;
    protected JwtRepository $jwtRepository;


    public function initialize(): void
    {
        parent::initialize();

        $this->usersRepository = new UsersRepository(
            TableRegistry::getTableLocator()->get('Users')
        );
        $this->jwtRepository = new JwtRepository(env('SERCRET_KEY'));
    }



    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function login()
    {
        try {
            $requestData = $this->request->getData();

            $email = $requestData['email'];
            $password = $requestData['password'];

            $user = $this->usersRepository->getUserWithEmail($email);

            $this->jwtRepository->check(
                $password,
                $user->password
            );


            $token = $this->jwtRepository->generateToken($user->id);

            $this->set('token', $token);
            $this->viewBuilder()->setOption('serialize', ['token']);

        } catch (Exception $err) {

            $error = [
                'message' => 'Erro interno do servidor',
            ];

            $httpStatusCode = 500;


            if ($err instanceof InvalidPasswordException || $err instanceof UserNotFoundException) {
                $error = [
                    'message' => $err->getMessage(),
                    'details' => $err->getErrorsMessages(),
                ];

                $httpStatusCode = 401;
            }

            $this->response = $this->response->withStatus($httpStatusCode);

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }
    }
}
