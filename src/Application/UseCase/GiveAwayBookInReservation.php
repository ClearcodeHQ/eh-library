<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\BookInReservationAlreadyGivenAway;
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
     * @param \DateTime     $givenAwayAt
     *
     * @throws BookInReservationAlreadyGivenAway
     */
    public function giveAway(UuidInterface $reservationId, \DateTime $givenAwayAt)
    {
        $reservation = $this->reservations->get($reservationId);

        if ($this->reservations->existsAlreadyGivenOfBook($reservation->bookId())) {
            throw new BookInReservationAlreadyGivenAway(sprintf('Book with id %s in reservation with id %s was already given away.', $reservation->bookId(), $reservation->id()));
        }

        $reservation->giveAway($givenAwayAt);

        $this->reservations->save($reservation);
    }
}
