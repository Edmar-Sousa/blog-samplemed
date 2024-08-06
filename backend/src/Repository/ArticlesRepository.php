<?php declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\ArticleNotFoundException;
use App\Exceptions\ValidationException;
use App\Model\Entity\Article;
use App\Model\Table\ArticlesTable;

class ArticlesRepository
{
    protected ArticlesTable $articlesTable;


    public function __construct(ArticlesTable $articlesTable)
    {
        $this->articlesTable = $articlesTable;
    }



    public function saveArticle(array $articleData): Article
    {
        $articleEntity = $this->articlesTable->newEntity($articleData);

        if (!$this->articlesTable->save($articleEntity))
            throw new ValidationException('Erro ao criar o artigo', $articleEntity->getErrors());


        return $articleEntity;
    }


    public function getArticleWithId(string $articleId): Article
    {
        return $this->articlesTable->get($articleId);
    }



    public function updateArticleWithId(string $articleId, array $articleData)
    {

        $articleEntity = $this->getArticleWithId($articleId);
        $articleEntity = $this->articlesTable->patchEntity($articleEntity, $articleData);


        if (!$this->articlesTable->save($articleEntity))
            throw new ValidationException('Erro ao atualizar o artigo', $articleEntity->getErrors());


        return $articleEntity;
    }


    public function deleteArticleWithId(string $articleId, string $userId)
    {

        $articleEntity = $this->articlesTable->find()
            ->where([
                'id' => $articleId,
                'user_id' => $userId,
            ])
            ->first();

        if (is_null($articleEntity)) {
            throw new ArticleNotFoundException(
                'Artigo não encontrado ou não pertence a esse usuario',
            );

        }


        if (!$this->articlesTable->delete($articleEntity))
            throw new ValidationException('Erro ao deletar artigo', $articleEntity->getErrors());

        return $articleEntity;
    }
}
