<?php
declare(strict_types=1);

use Cake\Utility\Text;
use Cake\ORM\TableRegistry;
use Migrations\AbstractSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            'id' => Text::uuid(),
            'name' => 'Usuario Padrao',
            'username' => 'usuario_padrao',
            'email' => 'usuariopadrao@gmail.com',
            'password' => '123',
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        ];

        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $usersTable->deleteAll([]);

        $users = $usersTable->newEntity($data);
        $usersTable->save($users);



        $articlesTable = TableRegistry::getTableLocator()->get('Articles');
        $articlesTable->deleteAll([]);


        $articles = [
            'title' => 'Artigo de teste para popular o banco de dados',
            'content' => <<<HTML
                    <h1>
                        Vantagens de Utilizar o Faker no PHP para Popular Bancos de Dados
                    </h1>
                    
                    <br />
                    
                    <p>
                        O Faker é uma biblioteca PHP que permite gerar dados fictícios 
                        de maneira rápida e eficiente. Utilizar o Faker para popular 
                        bancos de dados oferece várias vantagens, tais como:
                    </p>

                    <br />
                    
                    <ul>
                        <li>
                            <strong>Facilidade de Uso:</strong>
                            O Faker possui uma interface simples e intuitiva, permitindo a criação
                            rápida de dados fictícios com apenas algumas linhas de
                            código.
                        </li>
                        <li>
                            <strong>Dados Realistas:</strong>
                            A biblioteca gera dados que parecem reais, como nomes, endereços
                             números de telefone e muito mais, o que
                            ajuda a testar a aplicação em condições mais próximas da realidade.
                        </li>
                        <li>
                            <strong>Customização:</strong>
                            O Faker permite customizar os dados gerados para atender a requisitos específicos
                            do projeto, como formatos de datas, padrões
                            de números de telefone e outras necessidades.
                        </li>
                        <li>
                            <strong>Automatização de Testes:</strong>
                            Com o Faker, é possível criar grandes volumes de dados para
                            testar a performance e a escalabilidade da aplicação,
                            bem como realizar testes automatizados com diferentes cenários.
                        </li>
                        <li>
                            <strong>Economia de Tempo:</strong>
                            Gerar dados manualmente pode ser demorado e sujeito a erros. O
                            Faker automatiza esse processo, permitindo que os desenvolvedores
                            se concentrem em outras tarefas importantes.
                        </li>
                    </ul>
                    <br />

                    <p>
                        Em resumo, o Faker é uma ferramenta poderosa e versátil para desenvolvedores 
                        PHP que precisam popular bancos de dados com dados de teste de maneira eficiente e realista.
                    </p>
                HTML,

            'banner_image' => 'aqui seria o path para imagem',
            'user_id' => $users->id,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),

            'tags' => [
                ['title' => 'php'],
                ['title' => 'cakephp'],
                ['title' => 'programacao'],
                ['title' => 'laravel'],
                ['title' => 'database'],
            ]
        ];

        $articleEntity = $articlesTable->newEntity($articles);
        $articlesTable->save($articleEntity);
    }
}
