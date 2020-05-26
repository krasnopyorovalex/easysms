<?php

declare(strict_types=1);

namespace App\EntityRepositories;

use Doctrine\ORM\EntityRepository;

final class PostRepository extends EntityRepository
{
    public function searchByTitle(string $keyword)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM App\Entities\Post p WHERE p.title LIKE :keyword");
        $query->setParameter('keyword', '%'.$keyword.'%');

        return $query->getResult();
    }
}
