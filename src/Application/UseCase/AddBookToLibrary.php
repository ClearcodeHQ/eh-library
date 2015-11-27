<?php

namespace Clearcode\EHLibrary\Application\UseCase;

use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\BookRepository;
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

    /**
     * @param BookRepository    $books
     * @param ManagerRepository $managers
     */
    public function __construct(BookRepository $books, ManagerRepository $managers)
    {
        $this->books    = $books;
        $this->managers = $managers;
    }

    /**
     * @param string $managerId
     * @param string $bookId
     * @param string $title
     */
    public function add($managerId, $bookId, $title)
    {
        $this->managers->get($managerId);

        if ($this->books->existsWithTitle($title)) {
            throw new \DomainException(sprintf('Book with title %s already exists', $title));
        }

        $this->books->add(new Book($bookId, $title));
    }
}
