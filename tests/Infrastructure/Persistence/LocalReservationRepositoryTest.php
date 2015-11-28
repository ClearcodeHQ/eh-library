<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;
use Clearcode\EHLibrary\Model\Reservation;
use Ramsey\Uuid\Uuid;

class LocalReservationRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalReservationRepository */
    private $repository;

    /** @test */
    public function it_can_get_all_reservations()
    {
        $reservation1 = new Reservation(Uuid::uuid4(), Uuid::uuid4(), 'employee@clearcode.cc');
        $reservation2 = new Reservation(Uuid::uuid4(), Uuid::uuid4(), 'another.employee@clearcode.cc');
        $this->repository->save($reservation1);
        $this->repository->save($reservation2);

        $this->assertCount(2, $this->repository->getAll());
    }

    /** @test */
    public function it_can_get_reservation_by_id()
    {
        $reservationId1 = Uuid::uuid4();

        $reservation1 = new Reservation($reservationId1, Uuid::uuid4(), 'employee@clearcode.cc');
        $reservation2 = new Reservation(Uuid::uuid4(), Uuid::uuid4(), 'another.employee@clearcode.cc');
        $this->repository->save($reservation1);
        $this->repository->save($reservation2);

        $this->assertEquals($reservation1, $this->repository->get($reservationId1));
    }

    /**
     * @test
     * @expectedException \Clearcode\EHLibrary\Model\ReservationDoesNotExist
     */
    public function it_fails_when_reservation_with_id_does_not_exist()
    {
        $reservationId = Uuid::uuid4();

        $this->repository->get($reservationId);
    }

    /** @test */
    public function it_can_remove_reservation()
    {
        $reservationId = Uuid::uuid4();
        $reservation   = new Reservation($reservationId, Uuid::uuid4(), 'employee@clearcode.cc');
        $this->repository->save($reservation);

        $this->repository->remove($reservationId);

        $this->assertEmpty($this->repository->getAll());
    }

    /**
     * @test
     * @expectedException \Clearcode\EHLibrary\Model\ReservationDoesNotExist
     */
    public function it_fails_when_reservation_to_remove_does_not_exist()
    {
        $reservationId = Uuid::uuid4();

        $this->repository->remove($reservationId);
    }

    /** @test */
    public function it_return_empty_array_when_no_reservations()
    {
        $this->assertEmpty($this->repository->getAll());
    }

    /** @test */
    public function it_can_be_cleared()
    {
        $reservation1 = new Reservation(Uuid::uuid4(), Uuid::uuid4(), 'employee@clearcode.cc');
        $reservation2 = new Reservation(Uuid::uuid4(), Uuid::uuid4(), 'another.employee@clearcode.cc');

        $this->repository->save($reservation1);
        $this->repository->save($reservation2);

        $this->repository->clear();

        $this->assertEmpty($this->repository->getAll());
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->repository = new LocalReservationRepository();
        $this->repository->clear();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
