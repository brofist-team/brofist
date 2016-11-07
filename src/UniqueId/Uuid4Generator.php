<?php

namespace Brofist\UniqueId;

use Ramsey\Uuid\Uuid;

class Uuid4Generator implements UniqueIdGeneratorInterface
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function generate() : UniqueId
    {
        return new UniqueId(Uuid::uuid4());
    }
}
