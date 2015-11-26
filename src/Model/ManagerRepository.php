<?php

namespace Clearcode\EHLibrary\Model;

interface ManagerRepository
{
    /**
     * @param Manager $book
     */
    public function add(Manager $book);

    /**
     * @param int $bookId
     *
     * @throws \LogicException
     *
     * @return Manager
     */
    public function get($bookId);
}
