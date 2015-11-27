<?php

namespace Clearcode\EHLibrary\Model;

class Book
{
    /** @var string */
    private $bookId;
    /** @var string */
    private $title;
    /** @var string */
    private $authors;
    /** @var string */
    private $isbn;

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

    /**
     * @return string
     */
    public function id()
    {
        return $this->bookId;
    }

    /**
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function authors()
    {
        return $this->authors;
    }

    /**
     * @return string
     */
    public function isbn()
    {
        return $this->isbn;
    }
}
