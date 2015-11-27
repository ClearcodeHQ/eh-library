<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalWorkerRepository;
use Clearcode\EHLibrary\Model\Worker;

class LocalWorkerRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalWorkerRepository */
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
        LocalStorage::instance()->clear();

        $this->repository = new LocalWorkerRepository();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
