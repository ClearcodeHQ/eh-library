<?php

namespace Clearcode\EHLibrary\Model;

interface BookRepository
{
    /**
     * @param Book $book
     */
    public function add(Book $book);

    /**
     * @return int
     */
    public function count();
}
