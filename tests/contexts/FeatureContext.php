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
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalListOfBooksProjection;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalListReservationsForBookProjection;
use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\Reservation;
use Ramsey\Uuid\Uuid;

/**
 * @todo propably catching exceptions could be done with listener
 */
class FeatureContext extends BehatContext
{
    /** @var array */
    private $projection;
    /** @var \Exception[] */
    private $exceptions;

    /** @BeforeScenario */
    public function clearStorage()
    {
        LocalStorage::instance(true)->clear();
        $this->bookRepository()->clear();
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
        $this->reservationRepository()->add(new Reservation(Uuid::uuid4(), Uuid::fromString($bookId), $email));
    }

    /**
     * @Given /^there are reservations$/
     */
    public function thereAreReservations(TableNode $table)
    {
        $reservationsData = $table->getRows();

        array_shift($reservationsData);

        foreach ($reservationsData as $reservationData) {
            $this->reservationRepository()->add(new Reservation(Uuid::fromString($reservationData[0]), Uuid::fromString($reservationData[1]), $reservationData[2]));
        }
    }

    /**
     * @Given /^book from reservation "([^"]*)" was given away$/
     */
    public function bookFromReservationWasGivenAway($reservationId)
    {
        $reservation = $this->reservationRepository()->get(Uuid::fromString($reservationId));
        $reservation->giveAway();

        $this->reservationRepository()->add($reservation);
    }

    /**
     * @When /^I add book$/
     */
    public function iAddBook(TableNode $table)
    {
        $bookData = $table->getRows()[1];

        $useCase = new AddBookToLibrary($this->bookRepository());
        $useCase->add($bookData[0], $bookData[1], $bookData[2], $bookData[3]);
    }

    /**
     * @When /^I list books$/
     */
    public function iListBooks()
    {
        $this->projection = (new LocalListOfBooksProjection())->get();
    }

    /**
     * @When /^I list (\d+) page of books paginated by (\d+) books on page$/
     */
    public function iListPageOfBooksPaginatedByBooksOnPage($page, $booksPerPage)
    {
        $this->projection = (new LocalListOfBooksProjection())->get($page, $booksPerPage);
    }

    /**
     * @When /^I reserve book "([^"]*)" as "([^"]*)"$/
     */
    public function iReserveBookAs($bookId, $email)
    {
        $useCase = new CreateReservation($this->reservationRepository());
        $useCase->create($bookId, $email);
    }

    /**
     * @When /^I give away book form reservation "([^"]*)"$/
     */
    public function iGiveAwayBookFormReservation($reservationId)
    {
        try {
            $useCase = new GiveAwayBookInReservation($this->reservationRepository());
            $useCase->giveAway($reservationId);
        } catch (\Exception $e) {
            $this->exceptions[] = $e;
        }
    }

    /**
     * @When /^I give back a book from reservation "([^"]*)"$/
     */
    public function iGiveBackABookFromReservation($reservationId)
    {
        $useCase = new GiveBackBookFromReservation($this->reservationRepository());
        $useCase->giveBack($reservationId);
    }

    /**
     * @When /^I list reservations for book "([^"]*)"$/
     */
    public function iListReservationsForBook($bookId)
    {
        $this->projection = (new LocalListReservationsForBookProjection())->get(Uuid::fromString($bookId));
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
        \PHPUnit_Framework_Assert::assertEquals($expectedReservationCount, $this->reservationRepository()->count());
    }

    /**
     * @Given /^there should be (\d+) reservation for "([^"]*)"$/
     */
    public function thereShouldBeReservationFor($expectedReservationCount, $bookId)
    {
        \PHPUnit_Framework_Assert::assertEquals($expectedReservationCount, $this->reservationRepository()->countOfBook(Uuid::fromString($bookId)));
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
        //@todo listener for this, custom exception

        $result = false;

        foreach ($this->exceptions as $exception) {
            if ($exception instanceof \DomainException) {
                $result = true;
            }
        }

        \PHPUnit_Framework_Assert::assertTrue($result);
    }

    private function bookRepository()
    {
        return new LocalBookRepository();
    }

    private function reservationRepository()
    {
        return new LocalReservationRepository();
    }
}
