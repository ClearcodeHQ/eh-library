<?php

namespace Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\ListReservationsForBookProjection;
use Clearcode\EHLibrary\Application\Projection\ReservationView;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Model\Reservation;
use Ramsey\Uuid\UuidInterface;

class LocalListReservationsForBookProjection implements ListReservationsForBookProjection
{
    /** @var LocalStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = LocalStorage::instance();
    }

    /** {@inheritdoc} */
    public function get(UuidInterface $bookId)
    {
        $reservations = [];

        $allReservations = $this->storage->find('reservation_');

        /** @var Reservation $singleReservation */
        foreach ($allReservations as $singleReservation) {
            $givenAwayAt = null;

            if ($singleReservation->isGivenAway()) {
                $givenAwayAt = $singleReservation->giveAwayAt()->format('Y-m-d H:i:s');
            }

            if ($singleReservation->bookId()->equals($bookId)) {
                $reservations[] = new ReservationView((string) $singleReservation->id(), $singleReservation->email(), $givenAwayAt);
            }
        }

        return $reservations;
    }
}
