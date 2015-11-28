<?php

namespace Clearcode\EHLibrary\Application\Projection;

final class BookView
{
    /** @var string */
    public $bookId;
    /** @var string */
    public $title;
    /** @var string */
    public $authors;
    /** @var string */
    public $isbn;

    /**
     * @param string $bookId
     * @param string $title
     * @param string $authors
     * @param string $isbn
     */
    public function __construct($bookId, $title, $authors, $isbn)
    {
        $this->bookId  = $bookId;
        $this->title   = $title;
        $this->authors = $authors;
        $this->isbn    = $isbn;
    }
}
