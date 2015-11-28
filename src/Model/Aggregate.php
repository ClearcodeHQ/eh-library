<?php

namespace Clearcode\EHLibrary\Model;

use Ramsey\Uuid\UuidInterface;

interface Aggregate
{
    /**
     * @return UuidInterface
     */
    public function id();
}
