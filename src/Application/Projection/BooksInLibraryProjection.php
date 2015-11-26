<?php

namespace Clearcode\EHLibrary\Application\Projection;

interface BooksInLibraryProjection
{
    /**
     * @return BookView[]
     */
    public function get();
}
