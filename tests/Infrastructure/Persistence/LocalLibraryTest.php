<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalLibrary;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Model\Book;

class LocalLibraryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalLibrary */
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
        LocalStorage::instance()->clear();

        $this->library = new LocalLibrary();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->library = null;
    }
}
