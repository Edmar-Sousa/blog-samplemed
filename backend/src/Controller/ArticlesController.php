<?php
declare(strict_types=1);

namespace App\Controller;


use App\Repository\TagsRepository;
use App\Repository\UsersRepository;
use Cake\Http\Response;
use Exception;
use Cake\View\JsonView;
use Cake\ORM\TableRegistry;
use App\Services\UserService;

use App\Services\ArticleService;
use App\Repository\ArticlesRepository;

use Cake\Datasource\Paging\SimplePaginator;

class ArticlesController extends AppController
{

    protected ArticleService $articleService;
    protected UserService $userService;


    public function initialize(): void
    {
        parent::initialize();

        $userTable = TableRegistry::getTableLocator()->get('Users');
        $tagsTable = TableRegistry::getTableLocator()->get('Tags');

        $this->articleService = new ArticleService(
            new ArticlesRepository(
                $this->Articles,
                new TagsRepository($tagsTable)
            ),
        );

        $this->userService = new UserService(
            new UsersRepository($userTable)
        );
    }


    public function viewClasses(): array
    {
        return [JsonView::class];
    }



    public function index()
    {
        $page = (int) $this->request->getQuery('page', 1);
        $perPage = (int) $this->request->getQuery('per_page', 10);

        try {
            $articles = $this->articleService->getLatestArticles($page, $perPage);
            return $articles;
        } catch (Exception $err) {
            return $this->articleService->handlerException($err);
        }
    }


    public function add()
    {
        $this->request->allowMethod(['POST']);
        $userId = $this->request->getAttribute('user');


        try {
            $this->userService->checkIdUserLogged($userId);

            $articleData = $this->request->getData();
            return $this->articleService->createArticle($articleData, $userId);

        } catch (Exception $err) {

            return $this->articleService->handlerException($err);
        }
    }



    public function view(string $articleId)
    {
        $this->request->allowMethod(['GET']);

        try {
            return $this->articleService->viewArticleWithId($articleId);

        } catch (Exception $err) {

            return $this->articleService->handlerException($err);
        }
    }


    public function edit(string $articleId)
    {
        $this->request->allowMethod(['PUT']);

        try {
            $articleData = $this->request->getData();
            $this->articleService->updateArticle($articleId, $articleData);

        } catch (Exception $err) {

            return $this->articleService->handlerException($err);
        }

    }


    public function delete(string $articleId)
    {

        $this->request->allowMethod(['DELETE']);
        $userId = $this->request->getAttribute('user');

        try {
            $this->userService->checkIdUserLogged($userId);

            return $this->articleService->deleteArticle($articleId, $userId);

        } catch (Exception $err) {

            return $this->articleService->handlerException($err);
        }

    }
}
