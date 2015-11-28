<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\BookRepository;
use Ramsey\Uuid\Uuid;

class AddBookToLibrary
{
    /** @var BookRepository */
    private $books;

    /**
     * @param BookRepository $books
     */
    public function __construct(BookRepository $books)
    {
        $this->books = $books;
    }

    /**
     * @param $bookId
     * @param $title
     * @param $authors
     * @param $isbn
     */
    public function add($bookId, $title, $authors, $isbn)
    {
        $this->books->save(new Book(Uuid::fromString($bookId), $title, $authors, $isbn));
    }
}
