<?php

namespace Clearcode\EHLibrary\Model;

class Worker
{
    /** @var int */
    private $workerId;
    /** @var string */
    private $name;

    /**
     * @param int    $workerId
     * @param string $name
     */
    public function __construct($workerId, $name)
    {
        $this->workerId = $workerId;
        $this->name     = $name;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->workerId;
    }
}
