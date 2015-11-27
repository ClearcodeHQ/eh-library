<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Reservation;
use Clearcode\EHLibrary\Model\ReservationRepository;

class LocalReservationRepository implements ReservationRepository
{
    /** @var LocalStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = LocalStorage::instance();
    }

    /** {@inheritdoc} */
    public function add(Reservation $booking)
    {
        $this->storage->save('reservation_'.uniqid(), $booking);
    }

    /** {@inheritdoc} */
    public function countOfBook($bookId)
    {
        $reservations = [];

        /** @var Reservation $reservation */
        foreach ($this->storage->find('reservation_') as $reservation) {
            if ($reservation->bookId() == $bookId) {
                $reservations[] = $reservation;
            }
        }

        return count($reservations);
    }

    /** {@inheritdoc} */
    public function count()
    {
        return count($this->storage->find('reservation_'));
    }
}
