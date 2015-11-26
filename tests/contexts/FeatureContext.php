<?php

namespace tests\Clearcode\EHLibrary\contexts;

use Behat\Behat\Context\BehatContext;
use Clearcode\EHLibrary\Application\UseCase\AddBookToLibrary;
use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryBookRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryLibrary;
use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryManagerRepository;
use Clearcode\EHLibrary\Infrastructure\Persistence\InMemoryStorage;
use Clearcode\EHLibrary\Infrastructure\Projection\InMemoryBooksInLibraryProjection;
use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\Library;
use Clearcode\EHLibrary\Model\Manager;

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
        InMemoryStorage::instance()->clear();
        $this->library = new InMemoryLibrary();
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
    public function iAmAWorkerWithIdAndName($workerId)
    {
        $this->workerId = (int) $workerId;
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
        $this->library->addBook(new Book($bookId, $title));
    }

    /**
     * @Given /^there are no books in library$/
     */
    public function thereAreNoBooksInLibrary()
    {
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
     * @When /^I view books in library$/
     */
    public function iViewBooksInLibrary()
    {
        $this->view = (new InMemoryBooksInLibraryProjection())->get();
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

    private function bookRepository()
    {
        return new InMemoryBookRepository();
    }

    private function managerRepository()
    {
        return new InMemoryManagerRepository();
    }
}
