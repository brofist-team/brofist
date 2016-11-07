<?php

namespace Brofist\Hydrator;

class CollectionHydrator
{
    /** @var  HydratorInterface */
    private $hydrator;

    /**
     * CollectionHydrator constructor.
     */
    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @param array $collection
     * @param mixed $object
     *
     * @return array
     */
    public function hydrateCollection(array $collection, $object)
    {
        $objectCollection = [];

        foreach ($collection as $item) {
            $cloned = clone $object;
            $objectCollection[] = $this->hydrator->hydrate((array)$item, $cloned);
        }

        return $objectCollection;
    }
}
