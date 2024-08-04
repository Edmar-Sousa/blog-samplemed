<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $userTable = $this->table('users', ['id' => false]);

        $userTable
            ->addColumn('id', 'uuid', ['null' => false])
            ->addPrimaryKey('id')

            ->addColumn('username', 'string', ['null' => false, 'limit' => 50])
            ->addIndex('username', ['unique' => true])

            ->addColumn('name', 'string', ['null' => false, 'limit' => 100])
            ->addColumn('password', 'string', ['null' => false, 'limit' => 255])

            ->addColumn('email', 'string', ['null' => false, 'limit' => 255])
            ->addIndex('email', ['unique' => true])

            ->addTimestamps();

        $userTable->create();
    }
}
