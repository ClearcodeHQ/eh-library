<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryStorage;
use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryWorkerRepository;
use Clearcode\EHLibrary\Model\Worker;

class InMemoryWorkerRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var InMemoryWorkerRepository */
    private $repository;

    /** @test */
    public function it_can_get_worker_with_id()
    {
        $managerId = 1;

        $this->repository->add(new Worker($managerId, 'Lukasz'));

        $worker = $this->repository->get($managerId);

        $this->assertInstanceOf(Worker::class, $worker);
        $this->assertEquals($managerId, $worker->id());
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function it_fails_when_worker_does_not_exists()
    {
        $this->repository->get(999);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        InMemoryStorage::instance()->clear();

        $this->repository = new InMemoryWorkerRepository();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
