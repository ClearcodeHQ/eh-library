<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookingRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Model\Booking;

class LocalBookingRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalBookingRepository */
    private $repository;

    /** @test */
    public function it_can_get_bookings_of_worker()
    {
        $workerId = 1;

        $this->repository->add(new Booking($workerId, 1));
        $this->repository->add(new Booking($workerId, 2));
        $this->repository->add(new Booking(2, 3));

        $bookings = $this->repository->ofWorker($workerId);

        $this->assertCount(2, $bookings);
        $this->assertInstanceOf(Booking::class, $bookings[0]);
    }

    /** @test */
    public function it_returns_empty_when_bookings_of_worker_does_not_exists()
    {
        $this->assertEmpty($this->repository->ofWorker(999));
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        LocalStorage::instance(true)->clear();

        $this->repository = new LocalBookingRepository();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
