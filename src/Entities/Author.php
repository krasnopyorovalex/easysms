<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="authors")
 * @ORM\Entity(repositoryClass="App\EntityRepositories\AuthorRepository")
 */
class Author
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $fio;

    /**
     * @Column(type="string")
     * @var string
     */
    private $avatar;

    /**
     * @Column(type="string")
     * @var string
     */
    private $signature;

    /**
     * One author has many posts. This is the inverse side.
     * @OneToMany(targetEntity="Post", mappedBy="author")
     */
    private $posts;

    /**
     * Author constructor.
     * @param $fio
     * @param $avatar
     * @param $signature
     */
    public function __construct(string $fio, string $avatar, string $signature)
    {
        $this->fio = $fio;
        $this->avatar = $avatar;
        $this->signature = $signature;
        $this->posts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFio(): string
    {
        return $this->fio;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }
}
