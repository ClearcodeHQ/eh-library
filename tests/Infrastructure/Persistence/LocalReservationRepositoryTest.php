<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Model\Reservation;
use Ramsey\Uuid\Uuid;

class LocalReservationRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalReservationRepository */
    private $repository;

    /** @test */
    public function it_can_count_reservations()
    {
        $this->repository->add(new Reservation(Uuid::uuid4(), Uuid::uuid4(), 'employee@clearcode.cc'));
        $this->repository->add(new Reservation(Uuid::uuid4(), Uuid::uuid4(), 'another.employee@clearcode.cc'));

        $this->assertEquals(2, $this->repository->count());
    }

    /** @test */
    public function it_can_count_reservations_of_book()
    {
        $bookId1 = Uuid::uuid4();
        $bookId2 = Uuid::uuid4();

        $this->repository->add(new Reservation(Uuid::uuid4(), $bookId1, 'employee@clearcode.cc'));
        $this->repository->add(new Reservation(Uuid::uuid4(), $bookId1, 'another.employee@clearcode.cc'));
        $this->repository->add(new Reservation(Uuid::uuid4(), $bookId2, 'other.employee@clearcode.cc'));

        $this->assertEquals(2, $this->repository->countOfBook($bookId1));
    }

    /** @test */
    public function it_returns_zero_when_reservations()
    {
        $this->assertEquals(0, $this->repository->count());
    }

    /** @test */
    public function it_returns_zero_when_reservations_of_book_does_not_exists()
    {
        $this->assertEquals(0, $this->repository->countOfBook(Uuid::uuid4()));
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        LocalStorage::instance(true)->clear();

        $this->repository = new LocalReservationRepository();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
