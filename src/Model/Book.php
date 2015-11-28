<?php

namespace Clearcode\EHLibrary\Model;

use Ramsey\Uuid\UuidInterface;

final class Book implements Aggregate
{
    /** @var UuidInterface */
    private $bookId;
    /** @var string */
    private $title;
    /** @var string */
    private $authors;
    /** @var string */
    private $isbn;

    /**
     * @param UuidInterface $bookId
     * @param string        $title
     * @param string        $authors
     * @param string        $isbn
     */
    public function __construct(UuidInterface $bookId, $title, $authors, $isbn)
    {
        $this->bookId  = $bookId;
        $this->title   = $title;
        $this->authors = $authors;
        $this->isbn    = $isbn;
    }

    /**
     * @return UuidInterface
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
