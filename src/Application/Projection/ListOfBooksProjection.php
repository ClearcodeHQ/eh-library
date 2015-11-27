<?php

namespace Clearcode\EHLibrary\Application\Projection;

interface ListOfBooksProjection
{
    /**
     * @return BookView[]
     */
    public function get($page = 1, $booksPerPage = null);
}
