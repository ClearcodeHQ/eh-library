<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Manager;
use Clearcode\EHLibrary\Model\ManagerRepository;

class InMemoryManagerRepository implements ManagerRepository
{
    /** @var InMemoryStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = InMemoryStorage::instance();
    }

    /** {@inheritdoc} */
    public function add(Manager $manager)
    {
        $this->storage->add('manager_'.$manager->id(), $manager);
    }

    /** {@inheritdoc} */
    public function get($managerId)
    {
        return $this->storage->get('manager_'.$managerId);
    }
}
