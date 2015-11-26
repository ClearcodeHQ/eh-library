<?php

namespace tests\Clearcode\EHLibrary\Infrastructure;

use Clearcode\EHLibrary\Infrastructure\InMemoryLeaderRepository;
use Clearcode\EHLibrary\Infrastructure\InMemoryStorage;
use Clearcode\EHLibrary\Model\Leader;

class InMemoryLeaderRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var InMemoryLeaderRepository */
    private $repository;

    /** @test */
    public function it_can_get_leader_with_id()
    {
        $leaderId = 1;

        $this->repository->add(new Leader($leaderId));

        $leader = $this->repository->get($leaderId);

        $this->assertInstanceOf(Leader::class, $leader);
        $this->assertEquals($leaderId, $leader->id());
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function it_fails_when_leader_does_not_exists()
    {
        $this->repository->get(999);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        InMemoryStorage::instance()->clear();

        $this->repository = new InMemoryLeaderRepository();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
