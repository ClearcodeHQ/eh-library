<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\ReservationRepository;
use Ramsey\Uuid\Uuid;

class GiveAwayBookInReservation
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
    public function giveAway($reservationId)
    {
        $reservation = $this->reservations->get(Uuid::fromString($reservationId));
        $reservation->giveAway();

        $this->reservations->save($reservation);
    }
}
