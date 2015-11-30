<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Reservation;
use Clearcode\EHLibrary\Model\ReservationDoesNotExist;
use Clearcode\EHLibrary\Model\ReservationRepository;
use Everzet\PersistedObjects\AccessorObjectIdentifier;
use Everzet\PersistedObjects\FileRepository;
use Ramsey\Uuid\UuidInterface;

class LocalReservationRepository implements ReservationRepository
{
    /** @var FileRepository */
    private $file;

    public function clear()
    {
        $this->file->clear();
    }

    /** {@inheritdoc} */
    public function save(Reservation $reservation)
    {
        $this->file->save($reservation);
    }

    /** {@inheritdoc} */
    public function getAll()
    {
        return $this->file->getAll();
    }

    /** {@inheritdoc} */
    public function remove(UuidInterface $reservationId)
    {
        $reservation = $this->get($reservationId);

        $this->file->remove($reservation);
    }

    /** {@inheritdoc} */
    public function get(UuidInterface $reservationId)
    {
        if (null === $reservation = $this->file->findById($reservationId)) {
            throw new ReservationDoesNotExist(sprintf('Reservation with id %s does not exist.', $reservationId));
        }

        return $reservation;
    }

    /** {@inheritdoc} */
    public function existsAlreadyGivenOfBook(UuidInterface $bookId)
    {
        /** @var Reservation $reservation */
        foreach ($this->file->getAll() as $reservation) {
            if ($reservation->bookId()->equals($bookId) && $reservation->isGivenAway()) {
                return true;
            }
        }

        return false;
    }

    public function __construct()
    {
        $this->file = new FileRepository(__DIR__.'/../../../cache/reservations.db', new AccessorObjectIdentifier('id'));
    }
}
