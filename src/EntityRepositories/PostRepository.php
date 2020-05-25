<?php

declare(strict_types=1);

namespace App\EntityRepositories;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findByTitle(string $title)
    {
        $dql = "SELECT p FROM Post p WHERE LIKE p.title '%{$title}%'";

        $query = $this->getEntityManager()->createQuery($dql);

        return $query->getResult();
    }
}
