<?php

namespace tests\Clearcode\EHLibrary\contexts;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Clearcode\EHLibrary\Application\UseCase\AddBookToLibrary;
use Clearcode\EHLibrary\Application\UseCase\CreateReservation;
use Clearcode\EHLibrary\Application\UseCase\GiveAwayBookInReservation;
use Clearcode\EHLibrary\Application\UseCase\GiveBackBookFromReservation;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalListOfBooksProjection;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalListReservationsForBookProjection;
use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\Reservation;
use Ramsey\Uuid\Uuid;

class FeatureContext extends BehatContext
{
    /** @var array */
    private $projection;
    /** @var \Exception[] */
    private $exceptions;

    /** @BeforeScenario */
    public function clearDatabase()
    {
        $this->bookRepository()->clear();
        $this->reservationRepository()->clear();
    }

    /**
     * @Given /^I have books in library$/
     * @Given /^there are books$/
     */
    public function iHaveBooksInLibrary(TableNode $table)
    {
        $booksData = $table->getRows();

        array_shift($booksData);

        foreach ($booksData as $bookData) {
            $this->bookRepository()->save(new Book(Uuid::fromString($bookData[0]), $bookData[1], $bookData[2], $bookData[3]));
        }
    }

    /**
     * @Given /^there is reservation for "([^"]*)" by "([^"]*)"$/
     */
    public function thereIsReservationForBy($bookId, $email)
    {
        $this->reservationRepository()->save(new Reservation(Uuid::uuid4(), Uuid::fromString($bookId), $email));
    }

    /**
     * @Given /^there are reservations$/
     */
    public function thereAreReservations(TableNode $table)
    {
        $reservationsData = $table->getRows();

        array_shift($reservationsData);

        foreach ($reservationsData as $reservationData) {
            $this->reservationRepository()->save(new Reservation(Uuid::fromString($reservationData[0]), Uuid::fromString($reservationData[1]), $reservationData[2]));
        }
    }

    /**
     * @Given /^book from reservation "([^"]*)" was given away$/
     */
    public function bookFromReservationWasGivenAway($reservationId)
    {
        $reservation = $this->reservationRepository()->get(Uuid::fromString($reservationId));
        $reservation->giveAway();

        $this->reservationRepository()->save($reservation);
    }

    /**
     * @When /^I add book$/
     */
    public function iAddBook(TableNode $table)
    {
        $bookData = $table->getRows()[1];

        $this->execute(function () use ($bookData) {
            $useCase = new AddBookToLibrary($this->bookRepository());
            $useCase->add($bookData[0], $bookData[1], $bookData[2], $bookData[3]);
        });
    }

    /**
     * @When /^I list books$/
     */
    public function iListBooks()
    {
        $this->project(function () {
            return (new LocalListOfBooksProjection())->get();
        });
    }

    /**
     * @When /^I list (\d+) page of books paginated by (\d+) books on page$/
     */
    public function iListPageOfBooksPaginatedByBooksOnPage($page, $booksPerPage)
    {
        $this->project(function () use ($page, $booksPerPage) {
            return (new LocalListOfBooksProjection())->get($page, $booksPerPage);
        });
    }

    /**
     * @When /^I reserve book "([^"]*)" as "([^"]*)"$/
     */
    public function iReserveBookAs($bookId, $email)
    {
        $this->execute(function () use ($bookId, $email) {
            $useCase = new CreateReservation($this->reservationRepository());
            $useCase->create($bookId, $email);
        });
    }

    /**
     * @When /^I give away book form reservation "([^"]*)"$/
     */
    public function iGiveAwayBookFormReservation($reservationId)
    {
        $this->execute(function () use ($reservationId) {
            $useCase = new GiveAwayBookInReservation($this->reservationRepository());
            $useCase->giveAway($reservationId);
        });
    }

    /**
     * @When /^I give back a book from reservation "([^"]*)"$/
     */
    public function iGiveBackABookFromReservation($reservationId)
    {
        $this->execute(function () use ($reservationId) {
            $useCase = new GiveBackBookFromReservation($this->reservationRepository());
            $useCase->giveBack($reservationId);
        });
    }

    /**
     * @When /^I list reservations for book "([^"]*)"$/
     */
    public function iListReservationsForBook($bookId)
    {
        $this->project(function () use ($bookId) {
            return (new LocalListReservationsForBookProjection())->get(Uuid::fromString($bookId));
        });
    }

    /**
     * @Then /^I should have (\d+) book in library$/
     */
    public function iShouldHaveBookInLibrary($expectedBookCount)
    {
        \PHPUnit_Framework_Assert::assertCount((int) $expectedBookCount, $this->bookRepository()->getAll());
    }

    /**
     * @Then /^I should see (\d+) books$/
     * @Then /^I should see (\d+) book$/
     * @Then /^I should see (\d+) reservations$/
     */
    public function iShouldSeeBooks($expectedViewsCount)
    {
        \PHPUnit_Framework_Assert::assertCount((int) $expectedViewsCount, $this->projection);
    }

    /**
     * @Then /^there should be (\d+) reservation$/
     * @Then /^there should be (\d+) reservations$/
     */
    public function thereShouldBeReservation($expectedReservationCount)
    {
        \PHPUnit_Framework_Assert::assertCount((int) $expectedReservationCount, $this->reservationRepository()->getAll());
    }

    /**
     * @Given /^there should be (\d+) reservation for "([^"]*)"$/
     */
    public function thereShouldBeReservationFor($expectedReservationCount, $bookId)
    {
        \PHPUnit_Framework_Assert::assertCount((int) $expectedReservationCount, (new LocalListReservationsForBookProjection())->get(Uuid::fromString($bookId)));
    }

    /**
     * @Then /^book in reservation "([^"]*)" should be given away$/
     */
    public function bookInReservationShouldBeGivenAway($reservationId)
    {
        $reservation = $this->reservationRepository()->get(Uuid::fromString($reservationId));

        \PHPUnit_Framework_Assert::assertTrue($reservation->isGivenAway());
    }

    /**
     * @Then /^I should be warned that book is already given away$/
     */
    public function iShouldBeWarnedThatBookIsAlreadyGivenAway()
    {
        \PHPUnit_Framework_Assert::assertTrue($this->expectedExceptionWasThrown(\DomainException::class));
    }

    private function bookRepository()
    {
        return new LocalBookRepository();
    }

    private function reservationRepository()
    {
        return new LocalReservationRepository();
    }

    private function execute(\Closure $useCase)
    {
        try {
            $useCase();
        } catch (\Exception $e) {
            $this->exceptions[] = $e;
        }
    }

    private function project(\Closure $projection)
    {
        $this->projection = $projection();
    }

    private function expectedExceptionWasThrown($expectedExceptionClass)
    {
        return !empty(array_filter($this->exceptions, function (\Exception $exception) use ($expectedExceptionClass) {
            return $exception instanceof $expectedExceptionClass;
        }));
    }
}
