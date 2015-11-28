<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\BookView;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalListOfBooksProjection;
use Clearcode\EHLibrary\Model\Book;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class LocalListOfBooksProjectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalBookRepository */
    private $repository;
    /** @var LocalStorage */
    private $storage;
    /** @var LocalListOfBooksProjection */
    private $projection;

    /** @test */
    public function it_returns_books_in_library()
    {
        $this->addBook(Uuid::fromString('a7f0a5b1-b65a-4f9b-905b-082e255f6038'), 'Domain-Driven Design', 'Eric Evans', '0321125215');
        $this->addBook(Uuid::fromString('38483e7a-e815-4657-bc94-adc83047577e'), 'REST in Practice', 'Jim Webber, Savas Parastatidis, Ian Robinson', '978-0596805821');

        $books = $this->projection->get();

        $this->assertCount(2, $books);
        $this->assertInstanceOf(BookView::class, $books[0]);

        $this->assertEquals('a7f0a5b1-b65a-4f9b-905b-082e255f6038', $books[0]->bookId);
        $this->assertEquals('Domain-Driven Design', $books[0]->title);
        $this->assertEquals('Eric Evans', $books[0]->authors);
        $this->assertEquals('0321125215', $books[0]->isbn);
    }

    /** @test */
    public function it_returns_empty_array_when_no_books()
    {
        $this->assertEmpty($this->projection->get());
    }

    /** @test */
    public function it_returns_books_in_library_paginated()
    {
        $this->addBook(Uuid::fromString('a7f0a5b1-b65a-4f9b-905b-082e255f6038'), 'Domain-Driven Design', 'Eric Evans', '0321125215');
        $this->addBook(Uuid::fromString('38483e7a-e815-4657-bc94-adc83047577e'), 'REST in Practice', 'Jim Webber, Savas Parastatidis, Ian Robinson', '978-0596805821');
        $this->addBook(Uuid::fromString('979b4f4e-6c87-456a-a8b3-be6cff32b660'), 'Clean Code', 'Robert C. Martin', '978-0132350884');

        $books = $this->projection->get(2, 2);

        $this->assertEquals('979b4f4e-6c87-456a-a8b3-be6cff32b660', $books[0]->bookId);
        $this->assertEquals('Clean Code', $books[0]->title);
        $this->assertEquals('Robert C. Martin', $books[0]->authors);
        $this->assertEquals('978-0132350884', $books[0]->isbn);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->repository = new LocalBookRepository();
        $this->repository->clear();
        $this->projection = new LocalListOfBooksProjection();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->storage    = null;
        $this->repository = null;
        $this->projection = null;
    }

    private function addBook(UuidInterface $bookId, $title, $authors, $isbn)
    {
        $this->repository->save(new Book($bookId, $title, $authors, $isbn));
    }
}
