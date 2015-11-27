<?php

namespace Clearcode\EHLibrary\Model;

class Reservation
{
    /** @var int */
    private $email;
    /** @var int */
    private $bookId;

    /**
     * @param int $email
     * @param int $bookId
     */
    public function __construct($bookId, $email)
    {
        $this->bookId = $bookId;
        $this->email  = $email;
    }

    /**
     * @return string
     */
    public function bookId()
    {
        return $this->bookId;
    }
}
