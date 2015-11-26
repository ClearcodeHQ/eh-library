<?php

namespace Clearcode\EHLibrary\Application\Projection;

final class BookView
{
    /** @var int */
    public $bookId;
    /** @var string */
    public $title;

    /**
     * @param $bookId
     * @param $title
     */
    public function __construct($bookId, $title)
    {
        $this->bookId = $bookId;
        $this->title  = $title;
    }
}
