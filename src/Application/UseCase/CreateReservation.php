<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\Reservation;
use Clearcode\EHLibrary\Model\ReservationRepository;
use Ramsey\Uuid\Uuid;
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
     * @param UuidInterface $bookId
     * @param string        $email
     */
    public function create(UuidInterface $bookId, $email)
    {
        $this->reservations->save(new Reservation(Uuid::uuid4(), $bookId, $email));
    }
}
