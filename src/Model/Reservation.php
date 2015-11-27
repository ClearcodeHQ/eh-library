<?php

namespace Clearcode\EHLibrary\Model;

use Ramsey\Uuid\UuidInterface;

class Reservation
{
    /** @var UuidInterface */
    private $reservationId;
    /** @var int */
    private $email;
    /** @var int */
    private $bookId;

    /**
     * @param UuidInterface $reservationId
     * @param UuidInterface $bookId
     * @param string        $email
     */
    public function __construct(UuidInterface $reservationId, UuidInterface $bookId, $email)
    {
        $this->reservationId = $reservationId;
        $this->bookId        = $bookId;
        $this->email         = $email;
    }

    /**
     * @return UuidInterface
     */
    public function bookId()
    {
        return $this->bookId;
    }
}
