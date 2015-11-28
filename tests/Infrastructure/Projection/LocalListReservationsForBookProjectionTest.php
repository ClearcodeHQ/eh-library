<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\ReservationView;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalListReservationsForBookProjection;
use Clearcode\EHLibrary\Model\Reservation;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class LocalListReservationsForBookProjectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalReservationRepository */
    private $repository;
    /** @var LocalStorage */
    private $storage;
    /** @var LocalListReservationsForBookProjection */
    private $projection;

    /** @test */
    public function it_returns_list_of_reservations()
    {
        $bookId1 = Uuid::uuid4();
        $bookId2 = Uuid::uuid4();

        $this->addReservation(Uuid::fromString('38483e7a-e815-4657-bc94-adc83047577e'), $bookId1, 'employee@clearcode.cc');
        $this->addReservation(Uuid::fromString('a7f0a5b1-b65a-4f9b-905b-082e255f6038'), $bookId1, 'another.employee@clearcode.cc', true);
        $this->addReservation(Uuid::uuid4(), $bookId2, 'other.employee@clearcode.cc');

        $reservations = $this->projection->get($bookId1);

        $this->assertCount(2, $reservations);
        $this->assertInstanceOf(ReservationView::class, $reservations[0]);

        $this->assertEquals('38483e7a-e815-4657-bc94-adc83047577e', $reservations[0]->reservationId);
        $this->assertEquals('employee@clearcode.cc', $reservations[0]->email);
    }

    /** @test */
    public function it_returns_empty_when_no_reservations()
    {
        $this->assertEmpty($this->projection->get(Uuid::uuid4()));
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->storage = LocalStorage::instance(true);
        $this->storage->clear();

        $this->repository = new LocalReservationRepository();
        $this->projection = new LocalListReservationsForBookProjection();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->storage    = null;
        $this->repository = null;
        $this->projection = null;
    }

    private function addReservation(UuidInterface $reservationId, UuidInterface $bookId, $email, $givenAwayAt = false)
    {
        $reservation = new Reservation($reservationId, $bookId, $email);

        if ($givenAwayAt) {
            $reservation->giveAway();
        }

        $this->repository->add($reservation);
    }
}
