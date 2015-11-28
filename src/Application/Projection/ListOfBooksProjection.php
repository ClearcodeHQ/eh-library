<?php

namespace Clearcode\EHLibrary\Application\Projection;

interface ListOfBooksProjection
{
    /**
     * @param int  $page
     * @param null $booksPerPage
     *
     * @return BookView[]
     */
    public function get($page = 1, $booksPerPage = null);
}
