<?php

namespace Clearcode\EHLibrary\Infrastructure;

use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\BookRepository;

class InMemoryBookRepository implements BookRepository
{
    /** @var InMemoryStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = InMemoryStorage::instance();
    }

    /** {@inheritdoc} */
    public function add(Book $book)
    {
        $this->storage->add('book_'.$book->id(), $book);
    }

    /** {@inheritdoc} */
    public function get($bookId)
    {
        return $this->storage->get('book_'.$bookId);
    }
}
