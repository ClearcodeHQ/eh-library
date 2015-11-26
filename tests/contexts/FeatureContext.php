<?php

namespace tests\Clearcode\EHLibrary\contexts;

use Behat\Behat\Context\BehatContext;
use Clearcode\EHLibrary\Infrastructure\InMemoryBookRepository;
use Clearcode\EHLibrary\Infrastructure\InMemoryLibrary;
use Clearcode\EHLibrary\Infrastructure\InMemoryManagerRepository;
use Clearcode\EHLibrary\Infrastructure\InMemoryStorage;
use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\Library;
use Clearcode\EHLibrary\Model\Manager;
use Clearcode\EHLibrary\UseCase\AddBookToLibrary;

class FeatureContext extends BehatContext
{
    /** @var int */
    private $managerId;
    /** @var int */
    private $workerId;
    /** @var Library */
    private $library;

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
     * @Given /^I am a Worker with id (\d+)$/
     */
    public function iAmAWorkerWithId($workerId)
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

    private function bookRepository()
    {
        return new InMemoryBookRepository();
    }

    private function managerRepository()
    {
        return new InMemoryManagerRepository();
    }
}
