<?php

namespace Clearcode\EHLibrary;

use Clearcode\EHLibrary\Application\Projection\BookView;
use Clearcode\EHLibrary\Application\Projection\ReservationView;
use Clearcode\EHLibrary\Model\BookInReservationAlreadyGivenAway;
use Ramsey\Uuid\UuidInterface;

interface Library
{
    /**
     * @param UuidInterface $bookId
     * @param string        $title
     * @param string        $authors
     * @param string        $isbn
     */
    public function addBook(UuidInterface $bookId, $title, $authors, $isbn);

    /**
     * @param int  $page
     * @param null $booksPerPage
     *
     * @return BookView[]
     */
    public function listOfBooks($page = 1, $booksPerPage = null);

    /**
     * @param UuidInterface $bookId
     * @param string        $email
     */
    public function createReservation(UuidInterface $bookId, $email);

    /**
     * @param UuidInterface $reservationId
     *
     * @throws BookInReservationAlreadyGivenAway
     */
    public function giveAwayBookInReservation(UuidInterface $reservationId);

    /**
     * @param UuidInterface $reservationId
     */
    public function giveBackBookFromReservation(UuidInterface $reservationId);

    /**
     * @param UuidInterface $bookId
     *
     * @return ReservationView[]
     */
    public function listReservationsForBook(UuidInterface $bookId);
}
