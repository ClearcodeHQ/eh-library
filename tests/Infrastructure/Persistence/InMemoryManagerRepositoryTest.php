<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryManagerRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryStorage;
use Clearcode\EHLibrary\Model\Manager;

class InMemoryManagerRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var InMemoryManagerRepository */
    private $repository;

    /** @test */
    public function it_can_get_manager_with_id()
    {
        $managerId = 1;

        $this->repository->add(new Manager($managerId, 'Gosia'));

        $manager = $this->repository->get($managerId);

        $this->assertInstanceOf(Manager::class, $manager);
        $this->assertEquals($managerId, $manager->id());
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function it_fails_when_manager_does_not_exists()
    {
        $this->repository->get(999);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        InMemoryStorage::instance()->clear();

        $this->repository = new InMemoryManagerRepository();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
