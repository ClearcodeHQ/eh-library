<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryLibrary;
use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryStorage;
use Clearcode\EHLibrary\Model\Book;

class InMemoryLibraryTest extends \PHPUnit_Framework_TestCase
{
    /** @var InMemoryLibrary */
    private $library;

    /** @test */
    public function it_can_has_book()
    {
        $bookId = 1;

        $this->library->addBook(new Book($bookId, 'The NeverEnding Story'));

        $this->assertTrue($this->library->hasBook($bookId));
    }

    /** @test */
    public function it_can_has_not_book()
    {
        $this->assertFalse($this->library->hasBook(999));
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        InMemoryStorage::instance()->clear();

        $this->library = new InMemoryLibrary();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->library = null;
    }
}
