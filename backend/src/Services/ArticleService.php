<?php declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ArticleNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\ValidationException;
use App\Model\Entity\Article;
use App\Repository\ArticlesRepository;
use Cake\Datasource\Paging\PaginatedInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Exception;

class ArticleService
{
    protected ArticlesRepository $articlesRepository;


    public function __construct(ArticlesRepository $articlesRepository)
    {
        $this->articlesRepository = $articlesRepository;
    }



    private function serializeResponse(Response &$response, int $statusCode, array|Article|PaginatedInterface|null $body = null)
    {
        $response = $response->withStatus($statusCode)
            ->withType('application/json');


        if (!is_null($body))
            $response = $response->withStringBody(json_encode($body));
    }



    public function getLatestArticles(int $page, int $perPage)
    {
        $response = new Response();

        $articles = $this->articlesRepository->getLatestArticles($page, $perPage);

        $this->serializeResponse($response, 200, $articles);
        return $response;
    }


    public function viewArticleWithId(string $articleId)
    {

        $response = new Response();
        $article = $this->articlesRepository->getArticleWithId($articleId);

        $this->serializeResponse($response, 200, $article);

        return $response;
    }



    public function createArticle(array $articleData, string $userId)
    {
        $response = new Response();
        $article = $this->articlesRepository->saveArticle($articleData, $userId);

        $locationHeader = url([
            'action' => 'view',
            'id' => $article->id,
            '_ext' => 'json',
            'fullBase' => true
        ]);


        $this->response = $response->withAddedHeader('Location', $locationHeader);
        $this->serializeResponse($response, 201, $article);

        return $response;
    }


    public function updateArticle(string $articleId, array $articleData)
    {
        $response = new Response();
        $article = $this->articlesRepository->updateArticleWithId($articleId, $articleData);

        $this->serializeResponse($response, 200, $article);

        return $response;
    }


    public function deleteArticle(string $articleId, string $userId)
    {
        $response = new Response();
        $this->articlesRepository->deleteArticleWithId($articleId, $userId);

        $this->serializeResponse($response, 204);

        return $response;
    }


    private function handlerNotFoundException(Response &$response)
    {
        $error = [
            'message' => 'Artigo não encontrado',
        ];

        $this->serializeResponse($response, 404, $error);
    }

    private function handlerArticleNotFoundException(Response &$response, ArticleNotFoundException|UserNotFoundException $err)
    {
        $error = [
            'message' => $err->getMessage(),
        ];

        $this->serializeResponse($response, 404, $error);
    }


    private function handlerInternalError(Response &$response)
    {
        $error = [
            'message' => 'Error interno no servidor',
        ];

        $this->serializeResponse($response, 500, $error);
    }


    private function handlerValidationExceptio(Response &$response, ValidationException &$err)
    {
        $error = [
            'message' => $err->getMessage(),
            'details' => $err->getErrorsMessage(),
        ];

        $this->serializeResponse($response, 404, $error);
    }


    private function handlerPaginatorError(Response &$response)
    {
        $error = [
            'message' => 'Erro de paginação',
        ];

        $this->serializeResponse($response, 500, $error);
    }

    public function handlerException(Exception &$err)
    {
        $response = new Response();


        if ($err instanceof RecordNotFoundException)
            $this->handlerNotFoundException($response);
        else if ($err instanceof ValidationException)
            $this->handlerValidationExceptio($response, $err);
        else if ($err instanceof ArticleNotFoundException || $err instanceof UserNotFoundException)
            $this->handlerArticleNotFoundException($response, $err);
        else if ($err instanceof NotFoundException)
            $this->handlerPaginatorError($response);
        else
            $this->handlerInternalError($response);

        return $response;
    }
}

