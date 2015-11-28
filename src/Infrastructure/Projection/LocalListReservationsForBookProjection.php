<?php

namespace Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\ListReservationsForBookProjection;
use Clearcode\EHLibrary\Application\Projection\ReservationView;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;
use Clearcode\EHLibrary\Model\Reservation;
use Clearcode\EHLibrary\Model\ReservationRepository;
use Ramsey\Uuid\UuidInterface;

class LocalListReservationsForBookProjection implements ListReservationsForBookProjection
{
    /** @var ReservationRepository */
    private $repository;

    public function __construct()
    {
        $this->repository = new LocalReservationRepository();
    }

    /** {@inheritdoc} */
    public function get(UuidInterface $bookId)
    {
        $views = [];

        /** @var Reservation $reservation */
        foreach ($this->repository->getAll() as $reservation) {
            if (!$reservation->bookId()->equals($bookId)) {
                continue;
            }

            $views[] = new ReservationView(
                (string) $reservation->id(),
                $reservation->email(),
                ($reservation->isGivenAway()) ? $reservation->givenAwayAt()->format('Y-m-d H:i:s') : null
            );
        }

        return $views;
    }
}
