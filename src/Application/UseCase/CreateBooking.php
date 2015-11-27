<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\Booking;
use Clearcode\EHLibrary\Model\BookingRepository;
use Clearcode\EHLibrary\Model\BookRepository;
use Clearcode\EHLibrary\Model\WorkerRepository;

/**
 * @deprecated
 *
 * @todo rename this to create booking
 * @todo static constructor
 */
class CreateBooking
{
    /** @var WorkerRepository */
    private $workers;
    /** @var BookRepository */
    private $books;
    /** @var BookingRepository */
    private $bookings;

    /**
     * @param WorkerRepository  $workers
     * @param BookRepository    $books
     * @param BookingRepository $bookings
     */
    public function __construct(WorkerRepository $workers, BookRepository $books, BookingRepository $bookings)
    {
        $this->workers  = $workers;
        $this->books    = $books;
        $this->bookings = $bookings;
    }

    /**
     * @param int $workerId
     * @param int $bookId
     */
    public function book($workerId, $bookId)
    {
        $this->workers->get($workerId);
        $this->books->get($bookId);

        $this->bookings->add(new Booking($workerId, $bookId));
    }
}
