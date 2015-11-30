<?php

namespace Clearcode\EHLibrary\Model;

use Ramsey\Uuid\UuidInterface;

final class Reservation implements Aggregate
{
    /** @var UuidInterface */
    private $reservationId;
    /** @var UuidInterface */
    private $bookId;
    /** @var string */
    private $email;
    /** @var \DateTime */
    private $givenAwayAt;

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

    public function giveAway()
    {
        if ($this->isGivenAway()) {
            return;
        }

        $this->givenAwayAt = new \DateTime();
    }

    /**
     * @return bool
     */
    public function isGivenAway()
    {
        return $this->givenAwayAt instanceof \DateTime;
    }

    /**
     * @return UuidInterface
     */
    public function id()
    {
        return $this->reservationId;
    }

    /**
     * @return UuidInterface
     */
    public function bookId()
    {
        return $this->bookId;
    }

    /**
     * @return \DateTime
     */
    public function givenAwayAt()
    {
        return $this->givenAwayAt;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }
}
