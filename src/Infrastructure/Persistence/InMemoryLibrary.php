<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\Library;

class InMemoryLibrary implements Library
{
    /** @var InMemoryStorage */
    private $storage;
    /** @var Book[] */
    private $books;

    public function __construct()
    {
        $this->storage = InMemoryStorage::instance();

        if (!$this->storage->has('library_books')) {
            $this->storage->add('library_books', []);
        }

        $this->books = $this->storage->get('library_books');
    }

    /** {@inheritdoc} */
    public function addBook(Book $book)
    {
        $this->books[] = $book;

        $this->save();
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
        $this->storage->update('library_books', $this->books);
    }
}
