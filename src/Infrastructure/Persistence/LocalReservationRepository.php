<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Reservation;
use Clearcode\EHLibrary\Model\ReservationRepository;
use Ramsey\Uuid\UuidInterface;

class LocalReservationRepository implements ReservationRepository
{
    /** @var LocalStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = LocalStorage::instance();
    }

    /** {@inheritdoc} */
    public function add(Reservation $reservation)
    {
        $this->storage->save('reservation_'.(string) $reservation->id(), $reservation);
    }

    /** {@inheritdoc} */
    public function countOfBook(UuidInterface $bookId)
    {
        $reservations = [];

        /** @var Reservation $reservation */
        foreach ($this->storage->find('reservation_') as $reservation) {
            if ($reservation->bookId()->equals($bookId)) {
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

    /** {@inheritdoc} */
    public function remove(UuidInterface $reservationId)
    {
        $this->storage->remove('reservation_'.(string) $reservationId);
    }

    /**
     * @param UuidInterface $reservationId
     *
     * @return Reservation
     */
    public function get(UuidInterface $reservationId)
    {
        return $this->storage->get('reservation_'.(string) $reservationId);
    }
}
