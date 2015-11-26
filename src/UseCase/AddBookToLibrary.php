<?php

namespace Clearcode\EHLibrary\UseCase;

use Clearcode\EHLibrary\Model\BookRepository;
use Clearcode\EHLibrary\Model\LeaderRepository;
use Clearcode\EHLibrary\Model\Library;

class AddBookToLibrary
{
    /** @var BookRepository */
    private $books;
    /** @var LeaderRepository */
    private $leaders;
    /** @var Library */
    private $library;

    /**
     * @param BookRepository   $books
     * @param LeaderRepository $leaders
     * @param Library          $library
     */
    public function __construct(BookRepository $books, LeaderRepository $leaders, Library $library)
    {
        $this->books   = $books;
        $this->leaders = $leaders;
        $this->library = $library;
    }

    /**
     * @param int $leaderId
     * @param int $bookId
     */
    public function add($leaderId, $bookId)
    {
        $this->leaders->get($leaderId);
        $book = $this->books->get($bookId);

        $this->library->addBook($book);
    }
}
