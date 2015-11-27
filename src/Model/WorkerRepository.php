<?php

namespace Clearcode\EHLibrary\Model;

interface WorkerRepository
{
    /**
     * @param Worker $worker
     */
    public function add(Worker $worker);

    /**
     * @param int $workerId
     *
     * @throws \LogicException
     *
     * @return Worker
     */
    public function get($workerId);
}
