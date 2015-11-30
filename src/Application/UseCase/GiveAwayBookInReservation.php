<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\ReservationRepository;
use Ramsey\Uuid\UuidInterface;

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
     * @param UuidInterface $reservationId
     */
    public function giveAway(UuidInterface $reservationId)
    {
        $reservation = $this->reservations->get($reservationId);
        $reservation->giveAway();

        $this->reservations->save($reservation);
    }
}
