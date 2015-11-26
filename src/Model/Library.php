<?php

namespace Clearcode\EHLibrary\Model;

interface Library
{
    /**
     * @param Book $book
     */
    public function addBook(Book $book);

    /**
     * @param $bookId
     *
     * @return bool
     */
    public function hasBook($bookId);
}
