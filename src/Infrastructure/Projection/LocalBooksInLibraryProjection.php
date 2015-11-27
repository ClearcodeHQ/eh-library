<?php

namespace Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\BooksInLibraryProjection;
use Clearcode\EHLibrary\Application\Projection\BookView;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Model\Book;

class LocalBooksInLibraryProjection implements BooksInLibraryProjection
{
    /** @var LocalStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = LocalStorage::instance();
    }

    /** {@inheritdoc} */
    public function get()
    {
        $views = [];

        /** @var Book $book */
        foreach ($this->storage->find('book_') as $book) {
            $views[] = new BookView($book->id(), $book->title());
        }

        return $views;
    }
}
