<?php declare(strict_types=1);

namespace App\Services;

use App\Model\Entity\Article;
use App\Repository\ArticlesRepository;
use Cake\Http\Response;
use Exception;

class ArticleService
{
    protected ArticlesRepository $articlesRepository;


    public function __construct(ArticlesRepository $articlesRepository)
    {
        $this->articlesRepository = $articlesRepository;
    }



    private function serializeResponse(Response &$response, int $statusCode, array|Article $body)
    {
        $response = $response->withStatus($statusCode)
            ->withType('application/json')
            ->withStringBody(json_encode($body));
    }



    public function viewArticleWithId(string $articleId)
    {

        $response = new Response();
        $article = $this->articlesRepository->getArticleWithId($articleId);

        $this->serializeResponse($response, 200, $article);

        return $response;
    }



    private function handlerNotFoundException(Response &$response)
    {
        $error = [
            'message' => 'Artigo não encontrado',
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


    public function handlerException(Exception &$err)
    {
        $response = new Response();


        if ($err instanceof RecordNotFoundException)
            $this->handlerNotFoundException($response);
        else
            $this->handlerInternalError($response);

        return $response;
    }
}

