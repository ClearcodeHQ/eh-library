[![Build Status](https://travis-ci.org/ClearcodeHQ/eh-library.svg?branch=master)](https://travis-ci.org/ClearcodeHQ/eh-library)
[![Coverage Status](https://coveralls.io/repos/ClearcodeHQ/eh-library/badge.svg?branch=master&service=github)](https://coveralls.io/github/ClearcodeHQ/eh-library?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ClearcodeHQ/eh-library/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ClearcodeHQ/eh-library/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/565c16c64052e8003b00000e/badge.svg?style=flat)](https://www.versioneye.com/user/projects/565c16c64052e8003b00000e)

# EH-library Application for rest api course

This repository is a simple model which could be used to build REST API.

## Requirements
```json
    "require": {
        "php": ">=5.5",
        "ramsey/uuid": "~3.0",
        "everzet/persisted-objects": "~1.0"
    },
```

## Installation
```
composer require --dev clearcode/eh-library
```

## Features
- Add book to library,
- View books in library,
- Reserving a book,
- Give away a book,
- Give back a book,
- View reservations.

## Description

Api of library.

```php
//...
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
```

This interface is implement by `Clearcode\EHLibrary\Application` class.

## Example

Example of adding book to library.

```php
//..
namespace Clearcode;

use Clearcode\EHLibrary\Application;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function addBookToLibraryAction(Request $request)
    {
        $bookId = Uuid::uuid4();
        
        //Library implementation
        $app = new Application();
        $app->addBook($bookId, $request->request->get('title'), $request->request->get('authors'), $request->request->get('isbn'));
        
        return new Response(json_encode(['id' => (string) $bookId]), 201);
    }
}
```