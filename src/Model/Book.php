<?php

namespace Clearcode\EHLibrary\Model;

class Book
{
    /** @var int */
    private $bookId;
    /** @var string */
    private $title;

    /**
     * @param int    $bookId
     * @param string $title
     */
    public function __construct($bookId, $title)
    {
        $this->bookId = $bookId;
        $this->title  = $title;
    }

    /**
     * @return int
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
}
