<?php

namespace Clearcode\EHLibrary;

use Clearcode\EHLibrary\Application\UseCase\AddBookToLibrary;
use Clearcode\EHLibrary\Application\UseCase\CreateReservation;
use Clearcode\EHLibrary\Application\UseCase\GiveAwayBookInReservation;
use Clearcode\EHLibrary\Application\UseCase\GiveBackBookFromReservation;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalListOfBooksProjection;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalListReservationsForBookProjection;
use Ramsey\Uuid\UuidInterface;

final class Application implements Library
{
    /** {@inheritdoc} */
    public function addBook(UuidInterface $bookId, $title, $authors, $isbn)
    {
        (new AddBookToLibrary(new LocalBookRepository()))->add($bookId, $title, $authors, $isbn);
    }

    /** {@inheritdoc} */
    public function listOfBooks($page = 1, $booksPerPage = null)
    {
        return (new LocalListOfBooksProjection())->get($page, $booksPerPage);
    }

    /** {@inheritdoc} */
    public function createReservation(UuidInterface $bookId, $email)
    {
        (new CreateReservation(new LocalReservationRepository()))->create($bookId, $email);
    }

    /** {@inheritdoc} */
    public function giveAwayBookInReservation(UuidInterface $reservationId)
    {
        (new GiveAwayBookInReservation(new LocalReservationRepository()))->giveAway($reservationId);
    }

    /** {@inheritdoc} */
    public function giveBackBookFromReservation(UuidInterface $reservationId)
    {
        (new GiveBackBookFromReservation(new LocalReservationRepository()))->giveBack($reservationId);
    }

    /** {@inheritdoc} */
    public function listReservationsForBook(UuidInterface $bookId)
    {
        return (new LocalListReservationsForBookProjection())->get($bookId);
    }
}
