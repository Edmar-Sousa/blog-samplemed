<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ArticlesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ArticlesController Test Case
 *
 * @uses \App\Controller\ArticlesController
 */
class ArticlesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Articles',
        'app.Users',
    ];


    public function testAddArticle()
    {
        $articleData = [
            'title' => 'title writing in markdown',
            'content' => 'Content with **markdown**',
            'banner_image' => '/path/to/image.png',
            'user_id' => '798ce3f1-7cc7-4d37-a287-940413fc93ca',
        ];


        $this->post('/api/articles.json', $articleData);

        $this->assertResponseSuccess();

        $responseBody = (string) $this->_response->getBody();
        $responseArray = json_decode($responseBody, true);


        $this->assertArrayHasKey('article', $responseArray);
    }

    public function testValidationArticle()
    {
        $articleData = [
            'content' => 'Content with **markdown**',
            'banner_image' => '/path/to/image.png',
            'user_id' => '798ce3f1-7cc7-4d37-a287-940413fc93ca',
        ];


        $this->post('/api/articles.json', $articleData);

        $this->assertResponseError();

        $responseBody = (string) $this->_response->getBody();
        $responseArray = json_decode($responseBody, true);


        $this->assertArrayHasKey('error', $responseArray);
        $this->assertArrayHasKey('details', $responseArray['error']);
        $this->assertArrayHasKey('message', $responseArray['error']);
    }


    public function testViewArticle()
    {
        $this->get('/api/articles/8a83dbe9-cfdb-426c-bd0e-fcea336093ff.json');

        $this->assertResponseSuccess();

        $responseBody = (string) $this->_response->getBody();
        $responseArray = json_decode($responseBody, true);


        $this->assertArrayHasKey('article', $responseArray);
        $this->assertEquals('8a83dbe9-cfdb-426c-bd0e-fcea336093ff', $responseArray['article']['id']);
    }
}
