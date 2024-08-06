<?php declare(strict_types=1);

namespace App\Repository;

use App\Model\Entity\Article;
use App\Model\Table\TagsTable;


class TagsRepository
{

    protected TagsTable $tagsTable;


    public function __construct(TagsTable $tagsTable)
    {
        $this->tagsTable = $tagsTable;
    }



    public function getTagsWithName(array $tagsNames, Article &$article)
    {
        $tags = [];

        foreach ($tagsNames as $tagName) {
            $tagEntity = $this->tagsTable->findOrCreate(['title' => $tagName]);
            $tags[] = $tagEntity;
        }

        return $tags;
    }
}
