<?php

namespace Clearcode\EHLibrary\Infrastructure;

use Clearcode\EHLibrary\Model\Leader;
use Clearcode\EHLibrary\Model\LeaderRepository;

class InMemoryLeaderRepository implements LeaderRepository
{
    /** @var InMemoryStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = InMemoryStorage::instance();
    }

    /** {@inheritdoc} */
    public function add(Leader $leader)
    {
        $this->storage->add('leader_'.$leader->id(), $leader);
    }

    /** {@inheritdoc} */
    public function get($leaderId)
    {
        return $this->storage->get('leader_'.$leaderId);
    }
}
