<?php

namespace Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\BooksInLibraryProjection;
use Clearcode\EHLibrary\Application\Projection\BookView;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;

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

        foreach ($this->storage->get('library_books') as $book) {
            $views[] = new BookView($book->id(), $book->title());
        }

        return $views;
    }
}
