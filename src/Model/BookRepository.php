<?php

namespace Clearcode\EHLibrary\Model;

interface BookRepository
{
    /**
     * @param Book $book
     */
    public function save(Book $book);

    /**
     * @return Book[]
     */
    public function getAll();
}
