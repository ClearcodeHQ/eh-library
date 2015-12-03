<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\Reservation;
use Clearcode\EHLibrary\Model\ReservationRepository;
use Ramsey\Uuid\UuidInterface;

class CreateReservation
{
    /** @var ReservationRepository */
    private $reservations;

    /**
     * @param ReservationRepository $bookings
     */
    public function __construct(ReservationRepository $bookings)
    {
        $this->reservations = $bookings;
    }

    /**
     * @param UuidInterface $reservationId
     * @param UuidInterface $bookId
     * @param string        $email
     */
    public function create(UuidInterface $reservationId, UuidInterface $bookId, $email)
    {
        $this->reservations->save(new Reservation($reservationId, $bookId, $email));
    }
}
