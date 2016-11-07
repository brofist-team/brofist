<?php

namespace Brofist\Hydrator;

use Zend\Hydrator\HydratorInterface as ZendHydratorInterface;

class ZendHydratorAdapter implements HydratorInterface
{
    /**
     * @var ZendHydratorInterface
     */
    private $hydrator;

    public function __construct(ZendHydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function hydrate(array $data, $object)
    {
        $returned = $this->hydrator->hydrate($data, $object);

        if ($returned) {
            return $returned;
        }

        return $object;
    }

    public function extract($object)
    {
        return $this->hydrator->extract($object);
    }
}
