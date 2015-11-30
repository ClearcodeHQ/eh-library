[![Build Status](https://travis-ci.org/ClearcodeHQ/eh-library.svg?branch=master)](https://travis-ci.org/ClearcodeHQ/eh-library)

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

## Use cases

#### AddBookToLibrary

###### Description:

```gherkin
Feature: Add book to library
  In order to allow employees to borrow a book
  As a manager
  I need to be able to add book to library

  Scenario: Add book to library
     When I add book
        | id                                   | title                | authors    | isbn       |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans | 0321125215 |
     Then I should have 1 book in library
```

###### Example of usage:
```php
<?php

namespace Clearcode\EHLibrary;

use Clearcode\EHLibrary\Application\UseCase\AddBookToLibrary;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;

class Controller
{
    public function testAction()
    {
        $useCase = new AddBookToLibrary(new LocalBookRepository());
        $useCase->add('c28b71ce-3828-4957-8deb-11d9ee483c9e', 'Domain-Driven Design', 'Eric Evans', '0321125215');
    }
}
```
**Notice:** First argument of `AddBookToLibrary::add` should be valid `Uuid` string see [Uuid](https://en.wikipedia.org/wiki/Universally_unique_identifier).

#### CreateReservation

###### Description:

```gherkin
Feature: Reserving a book
  In order to take a book from the library
  As an employee
  I need to be able to reserve it

  Background:
    Given there are books
        | id                                   | title                | authors                                      | isbn           |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans                                   | 0321125215     |
        | 38483e7a-e815-4657-bc94-adc83047577e | REST in Practice     | Jim Webber, Savas Parastatidis, Ian Robinson | 978-0596805821 |

  Scenario: Reserving a book
     When I reserve book "a7f0a5b1-b65a-4f9b-905b-082e255f6038" as "employee@clearcode.cc"
     Then there should be 1 reservation
      And there should be 1 reservation for "a7f0a5b1-b65a-4f9b-905b-082e255f6038"

  Scenario: Reserving another book
    Given there is reservation for "38483e7a-e815-4657-bc94-adc83047577e" by "employee@clearcode.cc"
     When I reserve book "a7f0a5b1-b65a-4f9b-905b-082e255f6038" as "another.employee@clearcode.cc"
     Then there should be 2 reservations
      And there should be 1 reservation for "a7f0a5b1-b65a-4f9b-905b-082e255f6038"

  Scenario: Reserving book again
    Given there is reservation for "38483e7a-e815-4657-bc94-adc83047577e" by "employee@clearcode.cc"
     When I reserve book "38483e7a-e815-4657-bc94-adc83047577e" as "another.employee@clearcode.cc"
     Then there should be 2 reservations
      And there should be 2 reservation for "38483e7a-e815-4657-bc94-adc83047577e"
```

###### Example of usage:
```php
<?php

namespace Clearcode\EHLibrary;

use Clearcode\EHLibrary\Application\UseCase\CreateReservation;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;

class Controller
{
    public function testAction()
    {
        $useCase = new CreateReservation(new LocalReservationRepository());
        $useCase->create('c28b71ce-3828-4957-8deb-11d9ee483c9e', 'employee@clearcode.cc');
    }
}
```

#### GiveAwayBookInReservation

###### Description:

```gherkin
Feature: Give away a book
  In order to allow employee to take a book
  As a manager
  I want to give it away

  Background:
    Given there are books
        | id                                   | title                | authors    | isbn       |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans | 0321125215 |
      And there are reservations
        | id                                   | book                                 | employee                      |
        | c4e8ca4b-4528-41ec-8700-856c2f186b00 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | employee@clearcode.cc         |
        | 75ad9b66-db69-404c-80a0-6acdfaf668d6 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | another.employee@clearcode.cc |

  Scenario: Give away a book
     When I give away book form reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00"
     Then book in reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00" should be given away

  Scenario: Give away book for second time
    Given book from reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00" was given away
     When I give away book form reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00"
     Then I should be warned that book is already given away
```

###### Example of usage:
```php
<?php

namespace Clearcode\EHLibrary;

use Clearcode\EHLibrary\Application\UseCase\GiveAwayBookInReservation;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;

class Controller
{
    public function testAction()
    {
        $useCase = new GiveAwayBookInReservation(new LocalReservationRepository());
        $useCase->giveAway('c28b71ce-3828-4957-8deb-11d9ee483c9e');
    }
}
```
**Notice:** First argument of `GiveAwayBookInReservation::giveAway` should be valid `Uuid` string. Reservation could be give away only once! If twice then `BookInReservationAlreadyGivenAway` will be  thrown.

#### GiveBackBookFromReservation

###### Description:

```gherkin
Feature: Give a book back
  In order to give away book to another employee
  As an employee
  I want to give back a book

  Background:
    Given there are books
        | id                                   | title                | authors    | isbn           |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans | 0321125215     |
      And there are reservations
        | id                                   | book                                 | employee              |
        | c4e8ca4b-4528-41ec-8700-856c2f186b00 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | employee@clearcode.cc |

  Scenario: Give a book back
    Given book from reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00" was given away
     When I give back a book from reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00"
     Then there should be 0 reservations
```

###### Example of usage:
```php
<?php

namespace Clearcode\EHLibrary;

use Clearcode\EHLibrary\Application\UseCase\GiveBackBookFromReservation;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;

class Controller
{
    public function testAction()
    {
        $useCase = new GiveBackBookFromReservation(new LocalReservationRepository());
        $useCase->giveBack('c28b71ce-3828-4957-8deb-11d9ee483c9e');
    }
}
```
**Notice:** First argument of `GiveBackBookFromReservation::giveBack` should be valid `Uuid` string.

## Projections

#### ListOfBooksProjection

###### Description:

```gherkin
Feature: Views books in library
  In order to choose book to read
  As an employee
  I need to be able to view books in library

  Background:
    Given I have books in library
        | id                                   | title                | authors                                      | isbn           |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans                                   | 0321125215     |
        | 38483e7a-e815-4657-bc94-adc83047577e | REST in Practice     | Jim Webber, Savas Parastatidis, Ian Robinson | 978-0596805821 |
        | 979b4f4e-6c87-456a-a8b3-be6cff32b660 | Clean Code           | Robert C. Martin                             | 978-0132350884 |

  Scenario: List books in library
     When I list books
     Then I should see 3 books

  Scenario: List books paginated
     When I list 2 page of books paginated by 2 books on page
     Then I should see 1 book
```

###### Example of usage:
```php
<?php

namespace Clearcode\EHLibrary;

use Clearcode\EHLibrary\Infrastructure\Projection\LocalListOfBooksProjection;

class Controller
{
    public function testAction()
    {
        $page = 1;
        $booksPerPage = 10;
        
        $projection = new LocalListOfBooksProjection();

        return $projection->get($page, $booksPerPage);
    }
}
```
**Notice:** Projection returns collection of objects `BookView` class.

#### ListReservationsForBookProjection

###### Description:

```gherkin
Feature: Views reservations in library
  In order to know how long I will be waiting for book
  As a employee
  I need to be able to view list of reservations

  Background:
    Given there are books
        | id                                   | title                | authors    | isbn       |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans | 0321125215 |
      And there are reservations
        | id                                   | book                                 | employee                      |
        | c4e8ca4b-4528-41ec-8700-856c2f186b00 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | employee@clearcode.cc         |
        | 75ad9b66-db69-404c-80a0-6acdfaf668d6 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | another.employee@clearcode.cc |

  Scenario: View books in library
     When I list reservations for book "a7f0a5b1-b65a-4f9b-905b-082e255f6038"
     Then I should see 2 reservations
```

###### Example of usage:
```php
<?php

namespace Clearcode\EHLibrary;

use Clearcode\EHLibrary\Infrastructure\Projection\LocalListOfBooksProjection;

class Controller
{
    public function testAction()
    {
        $projection = new LocalListReservationsForBookProjection();

        return $projection->get('75ad9b66-db69-404c-80a0-6acdfaf668d6');
    }
}
```
**Notice:** First argument of `ListReservationsForBookProjection::get` is id of book which have reservations. Projection returns collection of objects `ReservationView` class.