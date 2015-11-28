<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\BookRepository;
use Everzet\PersistedObjects\AccessorObjectIdentifier;
use Everzet\PersistedObjects\FileRepository;

class LocalBookRepository implements BookRepository
{
    /** @var FileRepository */
    private $file;

    public function clear()
    {
        $this->file->clear();
    }

    /** {@inheritdoc} */
    public function save(Book $book)
    {
        $this->file->save($book);
    }

    /** {@inheritdoc} */
    public function getAll()
    {
        return $this->file->getAll();
    }

    public function __construct()
    {
        $this->file = new FileRepository('cache/books.db', new AccessorObjectIdentifier('id'));
    }
}
