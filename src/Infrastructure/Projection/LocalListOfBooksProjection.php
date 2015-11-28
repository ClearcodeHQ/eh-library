<?php

namespace Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\BookView;
use Clearcode\EHLibrary\Application\Projection\ListOfBooksProjection;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\BookRepository;

class LocalListOfBooksProjection implements ListOfBooksProjection
{
    /** @var BookRepository */
    private $repository;

    public function __construct()
    {
        $this->repository = new LocalBookRepository();
    }

    /** {@inheritdoc} */
    public function get($page = 1, $booksPerPage = null)
    {
        $views = [];

        /** @var Book $book */
        foreach ($this->repository->getAll() as $book) {
            $views[] = new BookView((string) $book->id(), $book->title(), $book->authors(), $book->isbn());
        }

        if (null !== $booksPerPage) {
            return array_slice($views, $page * $booksPerPage - $booksPerPage, $booksPerPage);
        }

        return $views;
    }
}
