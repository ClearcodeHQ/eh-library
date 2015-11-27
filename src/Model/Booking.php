<?php

namespace Clearcode\EHLibrary\Model;

class Booking
{
    /** @var int */
    private $workerId;
    /** @var int */
    private $bookId;

    /**
     * @param int $workerId
     * @param int $bookId
     */
    public function __construct($workerId, $bookId)
    {
        $this->workerId = $workerId;
        $this->bookId   = $bookId;
    }

    /**
     * @return int
     */
    public function workerId()
    {
        return $this->workerId;
    }
}
