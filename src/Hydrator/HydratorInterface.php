<?php

namespace Brofist\Hydrator;

interface HydratorInterface
{
    /**
     * @param array $data
     * @param mixed $object
     *
     * @return mixed
     */
    public function hydrate(array $data, $object);

    /**
     * @param mixed $object
     *
     * @return array
     */
    public function extract($object);
}
