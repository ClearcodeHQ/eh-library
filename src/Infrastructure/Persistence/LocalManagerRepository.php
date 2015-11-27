<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Manager;
use Clearcode\EHLibrary\Model\ManagerRepository;

class LocalManagerRepository implements ManagerRepository
{
    /** @var LocalStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = LocalStorage::instance();
    }

    /** {@inheritdoc} */
    public function add(Manager $manager)
    {
        $this->storage->save('manager_'.$manager->id(), $manager);
    }

    /** {@inheritdoc} */
    public function get($managerId)
    {
        return $this->storage->get('manager_'.$managerId);
    }
}
