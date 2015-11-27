<?php

namespace Clearcode\EHLibrary\Model;

use Ramsey\Uuid\UuidInterface;

interface ReservationRepository
{
    /**
     * @param Reservation $booking
     */
    public function add(Reservation $booking);

    /**
     * @param UuidInterface $bookId
     *
     * @throws \LogicException
     *
     * @return Reservation[]
     */
    public function countOfBook(UuidInterface $bookId);

    /**
     * @return int
     */
    public function count();
}
