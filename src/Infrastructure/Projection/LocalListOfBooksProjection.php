<?php

namespace Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\BookView;
use Clearcode\EHLibrary\Application\Projection\ListOfBooksProjection;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Model\Book;

class LocalListOfBooksProjection implements ListOfBooksProjection
{
    /** @var LocalStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = LocalStorage::instance();
    }

    /** {@inheritdoc} */
    public function get($page = 1, $booksPerPage = null)
    {
        $views = [];

        /** @var Book $book */
        foreach ($this->storage->find('book_') as $book) {
            $views[] = new BookView((string) $book->id(), $book->title(), $book->authors(), $book->isbn());
        }

        if (null !== $booksPerPage) {
            return array_slice($views, $page * $booksPerPage - $booksPerPage, $booksPerPage);
        }

        return $views;
    }
}
