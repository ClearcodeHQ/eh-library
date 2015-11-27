<?php

namespace Clearcode\EHLibrary\Model;

interface Library
{
    /**
     * @param Book $book
     */
    public function addBook(Book $book);

    /**
     * @param int $bookId
     * @param int $workerId
     */
    public function book($workerId, $bookId);

    /**
     * @param int $workerId
     *
     * @return bool
     */
    public function hasBooking($workerId);

    /**
     * @param int $bookId
     *
     * @return bool
     */
    public function hasBook($bookId);
}
