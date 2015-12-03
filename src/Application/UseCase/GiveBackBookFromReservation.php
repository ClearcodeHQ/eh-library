<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\CannotGiveBackReservationWhichWasNotGivenAway;
use Clearcode\EHLibrary\Model\ReservationRepository;
use Ramsey\Uuid\UuidInterface;

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
     * @param UuidInterface $reservationId
     *
     * @throws CannotGiveBackReservationWhichWasNotGivenAway
     */
    public function giveBack(UuidInterface $reservationId)
    {
        $reservation = $this->reservations->get($reservationId);

        if (!$reservation->isGivenAway()) {
            throw new CannotGiveBackReservationWhichWasNotGivenAway(sprintf('Cannot give back reservation %s which was not given away.', $reservation->id()));
        }

        $this->reservations->remove($reservationId);
    }
}
