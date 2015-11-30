<?php

namespace tests\Clearcode\EHLibrary\Model;

use Clearcode\EHLibrary\Model\Reservation;
use Ramsey\Uuid\Uuid;

class ReservationTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function book_in_reservation_can_be_given_away()
    {
        $reservation = new Reservation(Uuid::uuid4(), Uuid::uuid4(), 'employee@clearcode.cc');

        $reservation->giveAway();

        $this->assertTrue($reservation->isGivenAway());
        $this->assertInstanceOf(\DateTime::class, $reservation->givenAwayAt());
    }
}
