<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryStorage;
use Clearcode\EHLibrary\Model\Book;

class InMemoryBookRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var InMemoryBookRepository */
    private $repository;

    /** @test */
    public function it_can_get_book_with_id()
    {
        $title  = 'The NeverEnding Story';
        $bookId = 1;

        $this->repository->add(new Book($bookId, $title));

        $book = $this->repository->get($bookId);

        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals($bookId, $book->id());
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function it_fails_when_book_does_not_exists()
    {
        $this->repository->get(999);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        InMemoryStorage::instance()->clear();

        $this->repository = new InMemoryBookRepository();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
