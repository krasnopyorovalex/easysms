<?php

declare(strict_types=1);

namespace App\Commands;

ini_set('memory_limit', '512M');

use App\Entities\Author;
use App\Entities\Category;
use App\Entities\Post;
use App\Infrastructure\Database\Connection;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManager;
use Faker\Factory;

class SetFakeDataCommand extends Command
{
    private const AUTHORS_COUNT = 2000;
    private const POSTS_COUNT = 100000;
    private const CATEGORIES_COUNT = 2500;
    private const BATCH_SIZE = 200;

    protected static $defaultName = 'db:set-data';

    /**
     * @var EntityManager
     */
    private $em;

    private $faker;

    /**
     * SetFakeDataCommand constructor.
     * @throws ORMException
     */
    public function __construct()
    {
        $this->em = Connection::create();
        $this->faker = Factory::create('ru_RU');
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ORMException
     * @throws MappingException
     * @throws OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->createAuthors();
        $this->createCategories();
        $this->createPosts();

        $output->writeln('complete');

        return 0;
    }

    /**
     * @throws ORMException
     * @throws MappingException
     * @throws OptimisticLockException
     */
    private function createAuthors()
    {
        for ($i = 1; $i <= self::AUTHORS_COUNT; $i++) {
            $fio = "{$this->faker->name}";
            $author = new Author(
                $fio,
                $this->faker->imageUrl(120, 120),
                "С уважением, {$fio}"
            );

            $this->em->persist($author);

            if (($i % self::BATCH_SIZE) === 0) {
                $this->em->flush();
                $this->em->clear();
            }
        }
        $this->em->flush();
        $this->em->clear(Author::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function createPosts()
    {
        $authors = $this->em->getRepository(Author::class)->findAll();
        $categories = $this->em->getRepository(Category::class)->findAll();

        for ($i = 1; $i <= self::POSTS_COUNT; $i++) {
            $toCategories = rand(1, 3);

            $author = $authors[array_rand($authors)];
            $post = new Post(
                $this->faker->sentence(rand(3, 20)),
                $this->faker->realText(100),
                $this->faker->realText(800)
            );

            $post->addAuthor($author);

            for ($j = 1; $j <= $toCategories; $j++) {
                $category = $categories[array_rand($categories)];
                if (! $post->getCategories()->contains($category)) {
                    $post->addCategory($category);
                }
            }

            $this->em->persist($post);

            if (($i % self::BATCH_SIZE) === 0) {
                $this->em->flush();
            }
        }
        $this->em->flush();
    }

    /**
     * @throws MappingException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function createCategories()
    {
        for ($i = 1; $i <= self::CATEGORIES_COUNT; $i++) {
            $hierarchy = rand(2, 3);
            $countChild = rand(0, 3);

            for ($j = 1; $j <= $hierarchy; $j++) {
                $category = $this->createCategory();
                $this->em->persist($category);

                if ($j > 1 && isset($parentCategory)) {
                    $category->addParent($parentCategory);
                    $parentCategory = $category;
                    $this->em->persist($category);

                    if ($countChild) {
                        for ($c = 1; $c <= $countChild; $c++) {
                            $categoryChild = $this->createCategory();
                            $categoryChild->addParent($parentCategory);
                            $this->em->persist($categoryChild);
                        }
                    }
                }
            }

            if (($i % self::BATCH_SIZE) === 0) {
                $this->em->flush();
                $this->em->clear(Category::class);
            }
        }
        $this->em->flush();
        $this->em->clear();
    }

    /**
     * @return Category
     */
    private function createCategory(): Category
    {
        return new Category(
            $this->faker->sentence(rand(3, 10))
        );
    }
}
