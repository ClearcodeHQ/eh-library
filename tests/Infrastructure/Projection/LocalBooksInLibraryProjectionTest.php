<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\BookView;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalBooksInLibraryProjection;
use Clearcode\EHLibrary\Model\Book;

class LocalBooksInLibraryProjectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalBookRepository */
    private $repository;
    /** @var LocalBooksInLibraryProjection */
    private $projection;
    /** @var LocalStorage */
    private $storage;

    /** @test */
    public function it_returns_books_in_library()
    {
        $this->addBook('The NeverEnding Story');
        $this->addBook('Fifty Shades of Grey');

        $books = $this->projection->get();

        $this->assertCount(2, $books);
        $this->assertInstanceOf(BookView::class, $books[0]);
        $this->assertEquals('The NeverEnding Story', $books[0]->title);
        $this->assertEquals('Fifty Shades of Grey', $books[1]->title);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->storage = LocalStorage::instance(true);
        $this->storage->clear();

        $this->repository = new LocalBookRepository();
        $this->projection = new LocalBooksInLibraryProjection();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->storage    = null;
        $this->repository = null;
        $this->projection = null;
    }

    private function addBook($title)
    {
        $this->repository->add(new Book(rand(1, 1000000), $title));
    }
}
