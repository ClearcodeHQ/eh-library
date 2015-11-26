<?php

namespace Clearcode\EHLibrary\Model;

class Leader
{
    /** @var int */
    private $leaderId;

    /**
     * @param int $leaderId
     */
    public function __construct($leaderId)
    {
        $this->leaderId = $leaderId;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->leaderId;
    }
}
