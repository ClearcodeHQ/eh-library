<?php

namespace Clearcode\EHLibrary\Model;

use Ramsey\Uuid\UuidInterface;

interface ReservationRepository
{
    /**
     * @param Reservation $reservation
     */
    public function save(Reservation $reservation);

    /**
     * @return Reservation[]
     */
    public function getAll();

    /**
     * @param UuidInterface $reservationId
     *
     * @throws ReservationDoesNotExist
     */
    public function remove(UuidInterface $reservationId);

    /**
     * @param UuidInterface $reservationId
     *
     * @throws ReservationDoesNotExist
     *
     * @return Reservation
     */
    public function get(UuidInterface $reservationId);
}
