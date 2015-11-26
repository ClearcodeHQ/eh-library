<?php

namespace Clearcode\EHLibrary\Model;

class Manager
{
    /** @var int */
    private $managerId;
    /** @var string */
    private $name;

    /**
     * @param int    $managerId
     * @param string $name
     */
    public function __construct($managerId, $name)
    {
        $this->managerId = $managerId;
        $this->name      = $name;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->managerId;
    }
}
