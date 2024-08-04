<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateArticles extends AbstractMigration
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
        $articlesTable = $this->table('articles', ['id' => false]);

        $articlesTable
            ->addColumn('id', 'uuid', ['null' => false])
            ->addPrimaryKey('id')

            ->addColumn('title', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('content', 'text', ['null' => false])
            ->addColumn('banner_image', 'string', ['null' => false, 'limit' => 255])

            ->addColumn('user_id', 'uuid', ['null' => false])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])

            ->addTimestamps();

        $articlesTable->create();
    }
}
