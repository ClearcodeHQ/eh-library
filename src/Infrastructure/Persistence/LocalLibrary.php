<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\Library;

/**
 * @todo simplify this class
 * @todo probably this class should work with objects instead of identifiers
 * @todo probably needless
 */
class LocalLibrary implements Library
{
    /** @var LocalStorage */
    private $storage;
    /** @var Book[] */
    private $books;

    public function __construct()
    {
        $this->storage = LocalStorage::instance();

        if (!$this->storage->has('library_books')) {
            $this->storage->save('library_books', []);
        }

        $this->books = $this->storage->get('library_books');
    }

    /** {@inheritdoc} */
    public function addBook(Book $book)
    {
        $this->books[] = $book;

        $this->save();
    }

    /**
     * {@inheritdoc}
     *
     * @todo simplify this
     */
    public function book($workerId, $bookId)
    {
        if (!$this->storage->has('bookings')) {
            $this->storage->save('bookings', []);
        }

        $bookings   = $this->storage->get('bookings');
        $bookings[] = ['worker' => $workerId, 'book' => $bookId];

        $this->storage->save('bookings', $bookings);
    }

    public function hasBooking($workerId)
    {
        if (!$this->storage->has('bookings')) {
            $this->storage->save('bookings', []);
        }

        $bookings = $this->storage->get('bookings');

        foreach ($bookings as $booking) {
            if ($booking['worker'] == $workerId) {
                return true;
            }
        }

        return false;
    }

    /** {@inheritdoc} */
    public function hasBook($bookId)
    {
        foreach ($this->books as $book) {
            if ($book->id() == $bookId) {
                return true;
            }
        }

        return false;
    }

    private function save()
    {
        $this->storage->save('library_books', $this->books);
    }
}
