<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\BookRepository;
use Ramsey\Uuid\UuidInterface;

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
     * @param UuidInterface $bookId
     * @param string        $title
     * @param string        $authors
     * @param string        $isbn
     */
    public function add(UuidInterface $bookId, $title, $authors, $isbn)
    {
        $this->books->save(new Book($bookId, $title, $authors, $isbn));
    }
}
