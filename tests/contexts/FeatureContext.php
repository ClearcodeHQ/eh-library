<?php

namespace tests\Clearcode\EHLibrary\contexts;

use Behat\Behat\Context\BehatContext;
use Clearcode\EHLibrary\Infrastructure\InMemoryBookRepository;
use Clearcode\EHLibrary\Infrastructure\InMemoryLeaderRepository;
use Clearcode\EHLibrary\Infrastructure\InMemoryLibrary;
use Clearcode\EHLibrary\Infrastructure\InMemoryStorage;
use Clearcode\EHLibrary\Model\Book;
use Clearcode\EHLibrary\Model\Leader;
use Clearcode\EHLibrary\Model\Library;
use Clearcode\EHLibrary\UseCase\AddBookToLibrary;

class FeatureContext extends BehatContext
{
    /** @var int */
    private $leaderId;
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
     * @Given /^I am a Leader with id (\d+)$/
     */
    public function iAmALeaderWithId($leaderId)
    {
        $this->leaderId = (int) $leaderId;
        $this->leaderRepository()->add(new Leader($leaderId));
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
            $useCase = new AddBookToLibrary($this->bookRepository(), $this->leaderRepository(), $this->library);
            $useCase->add($this->leaderId, $bookId);
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

    private function leaderRepository()
    {
        return new InMemoryLeaderRepository();
    }
}
