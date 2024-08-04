<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Articles',
        'app.Comments',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\UsersController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\UsersController::view()
     */
    public function testView(): void
    {
        // user fixture
        $this->get('/api/users/798ce3f1-7cc7-4d37-a287-940413fc93ca.json');

        $this->assertResponseSuccess();

        $responseBody = (string) $this->_response->getBody();
        $responseBodyArray = json_decode($responseBody, true);

        $this->assertArrayHasKey('user', $responseBodyArray);

        $this->assertEquals('teste', $responseBodyArray['user']['username']);
    }


    public function testFindUserNotExists()
    {
        $this->get('/api/users/798ce3f1-7cc7-4d37-a287-940413fc93cb.json');

        $this->assertResponseError();
        $this->assertResponseCode(404);

        $responseBody = (string) $this->_response->getBody();
        $responseBodyArray = json_decode($responseBody, true);

        $this->assertArrayHasKey('error', $responseBodyArray);
        $this->assertArrayHasKey('message', $responseBodyArray['error']);

    }


    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\UsersController::add()
     */
    public function testAdd(): void
    {
        $userData = [
            'username' => 'teste_user',
            'name' => 'Teste user',
            'password' => '123',
            'email' => 'testeuser@gmail.com',
        ];

        $this->post('/api/users.json', $userData);

        $this->assertResponseSuccess('Response returned error status');

        $this->assertResponseCode(201);
        $this->assertContentType('application/json');


        $responseBody = (string) $this->_response->getBody();
        $responseBodyArray = json_decode($responseBody, true);

        $this->assertArrayHasKey('user', $responseBodyArray);

        $this->assertEquals($userData['username'], $responseBodyArray['user']['username']);
    }


    public function testValidationAdd()
    {
        $userData = [];

        $this->post('/api/users.json', $userData);

        $this->assertResponseError();
        $this->assertContentType('application/json');


        $responseBody = (string) $this->_response->getBody();
        $responseBodyArray = json_decode($responseBody, true);

        $this->assertArrayHasKey('error', $responseBodyArray);
        $this->assertArrayHasKey('message', $responseBodyArray['error']);
        $this->assertArrayHasKey('details', $responseBodyArray['error']);


        $this->assertArrayHasKey('username', $responseBodyArray['error']['details']);
        $this->assertArrayHasKey('name', $responseBodyArray['error']['details']);
        $this->assertArrayHasKey('password', $responseBodyArray['error']['details']);
        $this->assertArrayHasKey('email', $responseBodyArray['error']['details']);
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\UsersController::edit()
     */
    public function testEdit(): void
    {
        $userData = [
            'username' => 'update_user',
            'name' => 'Update user',
            'email' => 'testeupdate10@gmail.com',
        ];

        $this->put('/api/users/798ce3f1-7cc7-4d37-a287-940413fc93ca.json', $userData);

        $this->assertResponseSuccess();

        $responseBody = (string) $this->_response->getBody();
        $responseBodyArray = json_decode($responseBody, true);

        $this->assertArrayHasKey('user', $responseBodyArray);
        $this->assertEquals($userData['username'], $responseBodyArray['user']['username']);

    }


    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\UsersController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
