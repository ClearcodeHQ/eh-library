<?php

namespace Clearcode\EHLibrary\Application\Projection;

final class ReservationView
{
    /** @var string */
    public $reservationId;
    /** @var string */
    public $email;
    /** @var string */
    public $givenAwayAt;

    /**
     * @param string $reservationId
     * @param string $email
     * @param string $givenAwayAt
     */
    public function __construct($reservationId, $email, $givenAwayAt)
    {
        $this->reservationId = $reservationId;
        $this->email         = $email;
        $this->givenAwayAt   = $givenAwayAt;
    }
}
