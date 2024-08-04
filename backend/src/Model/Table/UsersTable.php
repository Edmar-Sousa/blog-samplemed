<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Event\EventInterface;
use Cake\Validation\Validator;
use Cake\ORM\Query\SelectQuery;
use Cake\Datasource\EntityInterface;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users Model
 *
 * @property \App\Model\Table\ArticlesTable&\Cake\ORM\Association\HasMany $Articles
 * @property \App\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\User> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Articles', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id',
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
            ->scalar('username', 'O nome de usuário deve ser uma string.')
            ->maxLength('username', 50, 'O nome de usuário não pode ter mais de 50 caracteres.')
            ->requirePresence('username', 'create', 'O nome de usuário é obrigatório.')
            ->notEmptyString('username', 'O nome de usuário não pode estar vazio.')
            ->add('username', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Este nome de usuário já está em uso.'
            ]);

        $validator
            ->scalar('name', 'O nome deve ser uma string.')
            ->maxLength('name', 100, 'O nome não pode ter mais de 100 caracteres.')
            ->requirePresence('name', 'create', 'O nome é obrigatório.')
            ->notEmptyString('name', 'O nome não pode estar vazio.');

        $validator
            ->scalar('password', 'A senha deve ser uma string.')
            ->maxLength('password', 255, 'A senha não pode ter mais de 255 caracteres.')
            ->requirePresence('password', 'create', 'A senha é obrigatória.')
            ->notEmptyString('password', 'A senha não pode estar vazia.');

        $validator
            ->email('email', false, 'O e-mail deve ser válido.')
            ->requirePresence('email', 'create', 'O e-mail é obrigatório.')
            ->notEmptyString('email', 'O e-mail não pode estar vazio.')
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Este e-mail já está em uso.'
            ]);

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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isDirty('password'))
            $entity->password = (new DefaultPasswordHasher())->hash($entity->password);

        return true;
    }
}
