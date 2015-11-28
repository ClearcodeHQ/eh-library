<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\ReservationRepository;
use Ramsey\Uuid\Uuid;

class GiveBackBookFromReservation
{
    /** @var ReservationRepository */
    private $reservations;

    /**
     * @param ReservationRepository $reservations
     */
    public function __construct(ReservationRepository $reservations)
    {
        $this->reservations = $reservations;
    }

    /**
     * @param string $reservationId
     */
    public function giveBack($reservationId)
    {
        $this->reservations->remove(Uuid::fromString($reservationId));
    }
}
