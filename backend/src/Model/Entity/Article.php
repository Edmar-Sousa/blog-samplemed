<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $banner_image
 * @property string $user_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\Tag[] $tags
 */
class Article extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'title' => true,
        'content' => true,
        'banner_image' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'comments' => true,
        'tags' => true,
    ];
}
