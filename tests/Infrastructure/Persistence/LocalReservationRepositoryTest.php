<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Model\Reservation;

class LocalReservationRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalReservationRepository */
    private $repository;

    /** @test */
    public function it_can_count_reservations()
    {
        $this->repository->add(new Reservation(uniqid(), 'employee@clearcode.cc'));
        $this->repository->add(new Reservation(uniqid(), 'another.employee@clearcode.cc'));

        $this->assertEquals(2, $this->repository->count());
    }

    /** @test */
    public function it_can_count_reservations_of_book()
    {
        $bookId1 = uniqid();
        $bookId2 = uniqid();

        $this->repository->add(new Reservation($bookId1, 'employee@clearcode.cc'));
        $this->repository->add(new Reservation($bookId1, 'another.employee@clearcode.cc'));
        $this->repository->add(new Reservation($bookId2, 'other.employee@clearcode.cc'));

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
        $this->assertEquals(0, $this->repository->countOfBook(uniqid()));
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
