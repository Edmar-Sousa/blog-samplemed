<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateComments extends AbstractMigration
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
        $commentsTable = $this->table('comments', ['id' => false]);

        $commentsTable
            ->addColumn('id', 'uuid', ['null' => false])
            ->addPrimaryKey('id')

            ->addColumn('title', 'string', ['null' => false, 'limit' => 100])
            ->addColumn('content', 'text', ['null' => false])

            ->addColumn('article_id', 'uuid', ['null' => false])
            ->addForeignKey('article_id', 'articles', 'id', ['delete' => 'CASCADE'])

            ->addColumn('user_id', 'uuid', ['null' => false])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])

        ;

        $commentsTable->create();
    }
}
