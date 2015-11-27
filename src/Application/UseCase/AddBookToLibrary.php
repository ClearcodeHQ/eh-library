<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\BookRepository;
use Clearcode\EHLibrary\Model\Library;
use Clearcode\EHLibrary\Model\ManagerRepository;

/**
 * @todo refactor this use case, use case should create book
 * @todo how about static constructors for use cases ?
 */
class AddBookToLibrary
{
    /** @var BookRepository */
    private $books;
    /** @var ManagerRepository */
    private $managers;
    /** @var Library */
    private $library;

    /**
     * @param BookRepository    $books
     * @param ManagerRepository $managers
     * @param Library           $library
     */
    public function __construct(BookRepository $books, ManagerRepository $managers, Library $library)
    {
        $this->books    = $books;
        $this->managers = $managers;
        $this->library  = $library;
    }

    /**
     * @param int $managerId
     * @param int $bookId
     */
    public function add($managerId, $bookId)
    {
        $this->managers->get($managerId);
        $book = $this->books->get($bookId);

        $this->library->addBook($book);
    }
}
