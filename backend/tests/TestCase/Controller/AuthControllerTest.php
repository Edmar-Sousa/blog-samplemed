<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AuthController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AuthController Test Case
 *
 * @uses \App\Controller\AuthController
 */
class AuthControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Users',
    ];


    public function testIncorrectPasswordLogin()
    {

        $loginData = [
            'email' => 'usertestemail@gmail.com',
            'password' => '123',
        ];


        $this->post('/api/auth/login.json', $loginData);

        $this->assertResponseError();

        $responseBody = (string) $this->_response->getBody();
        $responseArray = json_decode($responseBody, true);


        $this->assertArrayHasKey('error', $responseArray);
    }

}
