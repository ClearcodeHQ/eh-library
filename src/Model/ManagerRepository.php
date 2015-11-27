<?php

namespace Clearcode\EHLibrary\Model;

/**
 * @todo manager probably should be hardcoded
 */
interface ManagerRepository
{
    /**
     * @param Manager $manager
     */
    public function add(Manager $manager);

    /**
     * @param int $managerId
     *
     * @throws \LogicException
     *
     * @return Manager
     */
    public function get($managerId);
}
