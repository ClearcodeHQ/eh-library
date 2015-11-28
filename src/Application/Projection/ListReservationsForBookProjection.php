<?php

namespace Clearcode\EHLibrary\Application\Projection;

use Ramsey\Uuid\UuidInterface;

interface ListReservationsForBookProjection
{
    /**
     * @param UuidInterface $bookId
     *
     * @return ReservationView[]
     */
    public function get(UuidInterface $bookId);
}
