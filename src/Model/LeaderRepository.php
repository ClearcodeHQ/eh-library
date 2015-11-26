<?php

namespace Clearcode\EHLibrary\Model;

interface LeaderRepository
{
    /**
     * @param Leader $book
     */
    public function add(Leader $book);

    /**
     * @param int $bookId
     *
     * @throws \LogicException
     *
     * @return Leader
     */
    public function get($bookId);
}
