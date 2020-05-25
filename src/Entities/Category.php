<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="categories")
 * @ORM\Entity(repositoryClass="App\EntityRepositories\CategoryRepository")
 */
class Category
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * One Category has Many Categories.
     * @OneToMany(targetEntity="Category", mappedBy="parent")
     */
    protected $children;

    /**
     * Many Categories have One Category.
     * @ManyToOne(targetEntity="Category", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * Many Categories have Many Posts.
     * @ManyToMany(targetEntity="Post", inversedBy="categories")
     * @JoinTable(name="categories_posts")
     */
    protected $posts;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->posts = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function addChildren(Category $category)
    {
        $this->children = $category;
    }

    public function addParent(Category $category)
    {
        $this->parent = $category;
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }
}
