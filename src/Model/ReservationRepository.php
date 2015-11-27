<?php

namespace Clearcode\EHLibrary\Model;

interface ReservationRepository
{
    /**
     * @param Reservation $booking
     */
    public function add(Reservation $booking);

    /**
     * @param int $bookId
     *
     * @throws \LogicException
     *
     * @return Reservation[]
     */
    public function countOfBook($bookId);

    /**
     * @return int
     */
    public function count();
}
