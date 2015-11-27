<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\BookRepository;
use Clearcode\EHLibrary\Model\Library;
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
    /** @var Library */
    private $library;

    /**
     * @param WorkerRepository $workers
     * @param BookRepository   $books
     * @param Library          $library
     */
    public function __construct(WorkerRepository $workers, BookRepository $books, Library $library)
    {
        $this->workers = $workers;
        $this->books   = $books;
        $this->library = $library;
    }

    /**
     * @param int $workerId
     * @param int $bookId
     */
    public function book($workerId, $bookId)
    {
        $this->workers->get($workerId);
        $this->books->get($bookId);

        $this->bookings->add(new Booking($workerId));

        $this->library->book($workerId, $bookId);
    }
}
