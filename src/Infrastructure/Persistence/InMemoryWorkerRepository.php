<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Worker;
use Clearcode\EHLibrary\Model\WorkerRepository;

class InMemoryWorkerRepository implements WorkerRepository
{
    /** @var InMemoryStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = InMemoryStorage::instance();
    }

    /** {@inheritdoc} */
    public function add(Worker $worker)
    {
        $this->storage->add('worker_'.$worker->id(), $worker);
    }

    /** {@inheritdoc} */
    public function get($workerId)
    {
        return $this->storage->get('worker_'.$workerId);
    }
}