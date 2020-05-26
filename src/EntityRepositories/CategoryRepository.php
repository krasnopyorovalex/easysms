<?php

declare(strict_types=1);

namespace App\EntityRepositories;

use Doctrine\ORM\EntityRepository;

final class CategoryRepository extends EntityRepository
{
    /**
     * @param int $id
     * @param string $keyword
     * @param bool $withChild
     * @return int|mixed|string
     */
    public function searchByCategoryIdAndPostTitle(int $id, string $keyword, bool $withChild = false)
    {
        if ($withChild) {
            $categoriesQuery = $this->getEntityManager()
                ->createQuery(
                    "SELECT c.id FROM App\Entities\Category c WHERE c.path LIKE :id"
                );

            $categoriesQuery->setParameter('id', "%/{$id}/%");
            $id = $categoriesQuery->getResult();
        }

        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT p FROM App\Entities\Post p
                    INNER JOIN p.categories c
                    WHERE p.title LIKE :keyword AND c.id IN (:id)"
            );

        $query->setParameters([
            'id' => $id,
            'keyword' => "%{$keyword}%"
        ]);

        return $query->getResult();
    }
}
