<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\BookRepository;

class LocalBookRepository implements BookRepository
{
    /** @var LocalStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = LocalStorage::instance();
    }

    /** {@inheritdoc} */
    public function add(Book $book)
    {
        $this->storage->save('book_'.$book->id(), $book);
    }

    /** {@inheritdoc} */
    public function get($bookId)
    {
        return $this->storage->get('book_'.$bookId);
    }
}
