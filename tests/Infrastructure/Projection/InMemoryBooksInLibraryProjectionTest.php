<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Projection;

use Clearcode\EHLibrary\Application\Projection\BookView;
use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryStorage;
use Clearcode\EHLibrary\Infrastructure\Projection\InMemoryBooksInLibraryProjection;
use Clearcode\EHLibrary\Model\Book;

class InMemoryBooksInLibraryProjectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var InMemoryBooksInLibraryProjection */
    private $projection;
    /** @var InMemoryStorage */
    private $storage;

    /** @test */
    public function it_returns_books_in_library()
    {
        $this->addBookToLibrary('The NeverEnding Story');
        $this->addBookToLibrary('Fifty Shades of Grey');

        $books = $this->projection->get();

        $this->assertCount(2, $books);
        $this->assertInstanceOf(BookView::class, $books[0]);
        $this->assertEquals('The NeverEnding Story', $books[0]->title);
        $this->assertEquals('Fifty Shades of Grey', $books[1]->title);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->storage = InMemoryStorage::instance();
        $this->storage->clear();

        $this->projection = new InMemoryBooksInLibraryProjection();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->projection = null;
    }

    private function addBookToLibrary($title)
    {
        if (!$this->storage->has('library_books')) {
            $this->storage->add('library_books', []);
        }

        $books   = $this->storage->get('library_books');
        $books[] = new Book(rand(1, 1000000), $title);

        $this->storage->update('library_books', $books);
    }
}
