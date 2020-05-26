<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * @Table(name="posts")
 * @Entity(repositoryClass="App\EntityRepositories\PostRepository")
 */
class Post
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * Many posts have one author. This is the owning side.
     * @ManyToOne(targetEntity="Author", inversedBy="posts")
     * @JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     */
    protected $author;

    /**
     * Many Posts have Many Categories.
     * @ManyToMany(targetEntity="Category", mappedBy="posts")
     */
    protected $categories;

    /**
     * @Column(type="string", length=512)
     * @var string
     */
    private $title;

    /**
     * @Column(type="text")
     * @var string
     */
    private $preview;

    /**
     * @Column(type="text")
     * @var string
     */
    private $text;

    public function __construct(string $title, string $preview, string $text)
    {
        $this->title = $title;
        $this->preview = $preview;
        $this->text = $text;
        $this->categories = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getPreview(): string
    {
        return $this->preview;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    public function addCategory(Category $category)
    {
        $category->addPost($this);
        $this->categories[] = $category;
    }

    public function addAuthor(Author $author)
    {
        $this->author = $author;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories(): ArrayCollection
    {
        return $this->categories;
    }
}
