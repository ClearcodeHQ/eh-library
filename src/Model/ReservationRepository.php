<?php

namespace Clearcode\EHLibrary\Model;

use Ramsey\Uuid\UuidInterface;

interface ReservationRepository
{
    /**
     * @param Reservation $reservation
     */
    public function add(Reservation $reservation);

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

    /**
     * @param UuidInterface $reservationId
     */
    public function remove(UuidInterface $reservationId);
}
