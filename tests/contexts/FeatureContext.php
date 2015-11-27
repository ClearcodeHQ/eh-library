<?php

namespace tests\Clearcode\EHLibrary\contexts;

use Behat\Behat\Context\BehatContext;
use Clearcode\EHLibrary\Application\UseCase\AddBookToLibrary;
use Clearcode\EHLibrary\Application\UseCase\BookingBook;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalLibrary;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalManagerRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;
use Clearcode\EHLibrary\Infrastructure\Persistence\LocalWorkerRepository;
use Clearcode\EHLibrary\Infrastructure\Projection\LocalBooksInLibraryProjection;
use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\Library;
use Clearcode\EHLibrary\Model\Manager;
use Clearcode\EHLibrary\Model\Worker;

class FeatureContext extends BehatContext
{
    /** @var int */
    private $managerId;
    /** @var int */
    private $workerId;
    /** @var Library */
    private $library;
    /** @var array */
    private $view;

    /** @BeforeScenario */
    public function clearStorage()
    {
        LocalStorage::instance(true)->clear();
        $this->library = new LocalLibrary();
    }

    /**
     * @Given /^I am a Manager with id (\d+) and name "([^"]*)"$/
     */
    public function iAmAManagerWithIdAndName($managerId, $name)
    {
        $this->managerId = (int) $managerId;
        $this->managerRepository()->add(new Manager($managerId, $name));
    }

    /**
     * @Given /^I am a Worker with id (\d+) and name "([^"]*)"$/
     */
    public function iAmAWorkerWithIdAndName($workerId, $name)
    {
        $this->workerId = (int) $workerId;
        $this->workerRepository()->add(new Worker($workerId, $name));
    }

    /**
     * @Given /^I have book with id (\d+) and title "([^"]*)"$/
     */
    public function iHaveBookWithIdAndTitle($bookId, $title)
    {
        $this->bookRepository()->add(new Book($bookId, $title));
    }

    /**
     * @Given /^there is book with id (\d+) and title "([^"]*)" in library$/
     */
    public function thereIsBookWithIdAndTitleInLibrary($bookId, $title)
    {
        $this->bookRepository()->add(new Book($bookId, $title));
        $this->library->addBook(new Book($bookId, $title));
    }

    /**
     * @Given /^there are no books in library$/
     */
    public function thereAreNoBooksInLibrary()
    {
    }

    /**
     * @Given /^there is book with id (\d+) booked by Worker with id (\d+)$/
     */
    public function thereIsBookWithIdBookedByWorkerWithId($bookId)
    {
        $this->bookRepository()->add(new Book($bookId, 'test'));
    }

    /**
     * @When /^I add book with id (\d+) to the library$/
     */
    public function iAddBookToTheLibrary($bookId)
    {
        try {
            $useCase = new AddBookToLibrary($this->bookRepository(), $this->managerRepository(), $this->library);
            $useCase->add($this->managerId, $bookId);
        } catch (\Exception $e) {
        }
    }

    /**
     * @When /^I booking book with id (\d+)$/
     */
    public function iBookingBookWithId($bookId)
    {
        try {
            $useCase = new BookingBook($this->workerRepository(), $this->bookRepository(), $this->library);
            $useCase->book($this->workerId, $bookId);
        } catch (\Exception $e) {
        }
    }

    /**
     * @When /^I view books in library$/
     */
    public function iViewBooksInLibrary()
    {
        $this->view = (new LocalBooksInLibraryProjection())->get();
    }

    /**
     * @Then /^the book with id (\d+) should be available in the library$/
     */
    public function theBookWithIdShouldBeAvailableInTheLibrary($bookId)
    {
        \PHPUnit_Framework_Assert::assertTrue($this->library->hasBook($bookId));
    }

    /**
     * @Then /^the book with id (\d+) should not be available in the library$/
     */
    public function theBookWithIdShouldNotBeAvailableInTheLibrary($bookId)
    {
        \PHPUnit_Framework_Assert::assertFalse($this->library->hasBook($bookId));
    }

    /**
     * @Then /^I should see (\d+) book$/
     */
    public function iShouldSeeBook($booksCount)
    {
        \PHPUnit_Framework_Assert::assertCount((int) $booksCount, $this->view);
    }

    /**
     * @Then /^I should not see any books$/
     */
    public function iShouldNotSeeAnyBooks()
    {
        \PHPUnit_Framework_Assert::assertEmpty($this->view);
    }

    /**
     * @Then /^I should have booking$/
     */
    public function iShouldHaveBooking()
    {
        \PHPUnit_Framework_Assert::assertTrue($this->library->hasBooking($this->workerId));
    }

    /**
     * @Then /^I should not have booking$/
     */
    public function iShouldNotHaveBooking()
    {
        \PHPUnit_Framework_Assert::assertFalse($this->library->hasBooking($this->workerId));
    }

    private function bookRepository()
    {
        return new LocalBookRepository();
    }

    private function managerRepository()
    {
        return new LocalManagerRepository();
    }

    private function workerRepository()
    {
        return new LocalWorkerRepository();
    }
}
