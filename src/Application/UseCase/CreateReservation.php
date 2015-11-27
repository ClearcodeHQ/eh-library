<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\Reservation;
use Clearcode\EHLibrary\Model\ReservationRepository;

class CreateReservation
{
    /** @var ReservationRepository */
    private $bookings;

    /**
     * @param ReservationRepository $bookings
     */
    public function __construct(ReservationRepository $bookings)
    {
        $this->bookings = $bookings;
    }

    /**
     * @param string $bookId
     * @param string $email
     */
    public function create($bookId, $email)
    {
        $this->bookings->add(new Reservation($bookId, $email));
    }
}
