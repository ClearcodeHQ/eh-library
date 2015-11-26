<?php

namespace tests\Clearcode\EHLibrary\contexts;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;

class FeatureContext extends BehatContext
{
    /**
     * @Given /^I am a Leader$/
     */
    public function iAmALeader()
    {
        throw new PendingException();
    }

    /**
     * @When /^I adds a book to the library$/
     */
    public function iAddsABookToTheLibrary()
    {
        throw new PendingException();
    }

    /**
     * @Then /^the book should be available in the library$/
     */
    public function theBookShouldBeAvailableInTheLibrary()
    {
        throw new PendingException();
    }
}
