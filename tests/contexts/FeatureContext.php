<?php

namespace tests\Clearcode\EHLibrary\contexts;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Clearcode\EHLibrary\Application\UseCase\AddBookToLibrary;
use Clearcode\EHLibrary\Application\UseCase\CreateReservation;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalReservationRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalListOfBooksProjection;
use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\Reservation;
use Ramsey\Uuid\Uuid;

class FeatureContext extends BehatContext
{
    /** @var array */
    private $projection;

    /** @BeforeScenario */
    public function clearStorage()
    {
        LocalStorage::instance(true)->clear();
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
            $this->bookRepository()->add(new Book(Uuid::fromString($bookData[0]), $bookData[1], $bookData[2], $bookData[3]));
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
    }

    /**
     * @Then /^I should have (\d+) book in library$/
     */
    public function iShouldHaveBookInLibrary($expectedBookCount)
    {
        \PHPUnit_Framework_Assert::assertEquals($expectedBookCount, $this->bookRepository()->count());
    }

    /**
     * @Then /^I should see (\d+) books$/
     * @Then /^I should see (\d+) book$/
     */
    public function iShouldSeeBooks($expectedBookCount)
    {
        \PHPUnit_Framework_Assert::assertCount((int) $expectedBookCount, $this->projection);
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
