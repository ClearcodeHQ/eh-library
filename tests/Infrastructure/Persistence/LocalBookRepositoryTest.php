<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Model\Book;
use Ramsey\Uuid\Uuid;

class LocalBookRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalBookRepository */
    private $repository;

    /** @test */
    public function it_can_count_books()
    {
        $this->repository->add(new Book(Uuid::fromString('a7f0a5b1-b65a-4f9b-905b-082e255f6038'), 'Domain-Driven Design', 'Eric Evans', '0321125215'));
        $this->repository->add(new Book(Uuid::fromString('38483e7a-e815-4657-bc94-adc83047577e'), 'REST in Practice', 'Jim Webber, Savas Parastatidis, Ian Robinson', '978-0596805821'));

        $this->assertEquals(2, $this->repository->count());
    }

    /** @test */
    public function it_returns_zero_when_no_books()
    {
        $this->assertEquals(0, $this->repository->count());
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        LocalStorage::instance(true)->clear();

        $this->repository = new LocalBookRepository();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
