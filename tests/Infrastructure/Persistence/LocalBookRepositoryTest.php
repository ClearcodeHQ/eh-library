<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Model\Book;

class LocalBookRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalBookRepository */
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
        LocalStorage::instance()->clear();

        $this->repository = new LocalBookRepository();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
