<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\Reservation;
use Clearcode\EHLibrary\Model\ReservationRepository;
use Ramsey\Uuid\Uuid;

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
     * @param string $bookId
     * @param string $email
     */
    public function create($bookId, $email)
    {
        $this->reservations->add(new Reservation(Uuid::uuid4(), Uuid::fromString($bookId), $email));
    }
}
