<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Articles Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\Article newEmptyEntity()
 * @method \App\Model\Entity\Article newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Article> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Article get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Article findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Article patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Article> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Article|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Article saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Article>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Article>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Article>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Article> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Article>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Article>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Article>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Article> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ArticlesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('articles');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'article_id',
        ]);
        $this->belongsToMany('Tags', [
            'through' => 'ArticlesTags',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('title', 'O título deve ser uma string.')
            ->maxLength('title', 255, 'O título não pode ter mais de 255 caracteres.')
            ->requirePresence('title', 'create', 'O título é obrigatório.')
            ->notEmptyString('title', 'O título não pode estar vazio.');

        $validator
            ->scalar('content', 'O conteúdo deve ser uma string.')
            ->requirePresence('content', 'create', 'O conteúdo é obrigatório.')
            ->notEmptyString('content', 'O conteúdo não pode estar vazio.');

        $validator
            ->scalar('banner_image', 'A imagem de banner deve ser uma string.')
            ->maxLength('banner_image', 255, 'A imagem de banner não pode ter mais de 255 caracteres.')
            ->requirePresence('banner_image', 'create', 'A imagem de banner é obrigatória.')
            ->notEmptyFile('banner_image', 'A imagem de banner não pode estar vazia.');

        $validator
            ->uuid('user_id', 'O ID do usuário deve ser um UUID válido.')
            ->notEmptyString('user_id', 'O ID do usuário não pode estar vazio.');


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
