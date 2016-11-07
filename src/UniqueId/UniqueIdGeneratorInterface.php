<?php

namespace Brofist\UniqueId;

interface UniqueIdGeneratorInterface
{
    public function generate() : UniqueId;
}
