<?php

declare(strict_types=1);

namespace App\Http\Traits;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

trait DataManagerTrait
{
    protected function collection($collection, $transformer)
    {
        $manager = $this->getArrayManager();

        return $manager->createData(new Collection($collection, $transformer))->toArray();
    }

    protected function item($item, $transformer)
    {
        $manager = $this->getArrayManager();

        return $manager->createData(new Item($item, $transformer))->toArray();
    }

    /**
     * @return Manager
     */
    private function getArrayManager()
    {
        return new Manager();
    }
}
