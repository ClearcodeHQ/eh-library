<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Model\Book;
use Ramsey\Uuid\Uuid;

class LocalBookRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalBookRepository */
    private $repository;

    /** @test */
    public function it_can_get_all_books()
    {
        $book1 = new Book(Uuid::fromString('a7f0a5b1-b65a-4f9b-905b-082e255f6038'), 'Domain-Driven Design', 'Eric Evans', '0321125215');
        $book2 = new Book(Uuid::fromString('38483e7a-e815-4657-bc94-adc83047577e'), 'REST in Practice', 'Jim Webber, Savas Parastatidis, Ian Robinson', '978-0596805821');

        $this->repository->save($book1);
        $this->repository->save($book2);

        $this->assertCount(2, $this->repository->getAll());
    }

    /** @test */
    public function it_return_empty_array_when_no_books()
    {
        $this->assertEmpty($this->repository->getAll());
    }

    /** @test */
    public function it_can_be_cleared()
    {
        $book1 = new Book(Uuid::fromString('a7f0a5b1-b65a-4f9b-905b-082e255f6038'), 'Domain-Driven Design', 'Eric Evans', '0321125215');
        $book2 = new Book(Uuid::fromString('38483e7a-e815-4657-bc94-adc83047577e'), 'REST in Practice', 'Jim Webber, Savas Parastatidis, Ian Robinson', '978-0596805821');
        $this->repository->save($book1);
        $this->repository->save($book2);

        $this->repository->clear();

        $this->assertEmpty($this->repository->getAll());
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->repository = new LocalBookRepository();
        $this->repository->clear();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
