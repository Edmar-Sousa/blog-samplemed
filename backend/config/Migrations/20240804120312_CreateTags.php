<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateTags extends AbstractMigration
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
        $tagsTable = $this->table('tags', ['id' => false]);

        $tagsTable
            ->addColumn('id', 'uuid', ['null' => false])
            ->addPrimaryKey('id')

            ->addColumn('title', 'string', ['null' => false, 'limit' => 255]);

        $tagsTable->create();
    }
}
