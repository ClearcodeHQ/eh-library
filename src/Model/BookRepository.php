<?php

namespace Clearcode\EHLibrary\Model;

interface BookRepository
{
    /**
     * @param Book $book
     */
    public function add(Book $book);

    /**
     * @param $title
     *
     * @return bool
     */
    public function existsWithTitle($title);

    /**
     * @param int $bookId
     *
     * @throws \LogicException
     *
     * @return Book
     */
    public function get($bookId);
}
