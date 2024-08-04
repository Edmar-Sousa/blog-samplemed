<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ArticlesTags extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {

        $articlesTagsTable = $this->table('articles_tags', ['id' => false]);

        $articlesTagsTable
            ->addColumn('id', 'uuid', ['null' => false])
            ->addPrimaryKey('id')

            ->addColumn('article_id', 'uuid', ['null' => false])
            ->addForeignKey('article_id', 'articles', 'id', ['delete' => 'CASCADE'])

            ->addColumn('tag_id', 'uuid', ['null' => false])
            ->addForeignKey('tag_id', 'tags', 'id', ['delete' => 'CASCADE']);

        $articlesTagsTable->create();

    }
}
