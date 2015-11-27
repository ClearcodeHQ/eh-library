@incomplete
Feature: Give a book back
  In order to read books by another workers
  As a worker
  I need to be able to give a book back to library

  Scenario: Give a book back to library
    Given I am a Worker with id 333 and name "Lukasz"
      And I have a book with id 123 borrowed
     When I give a book with id 123 back to library
     Then I should not have booking
      And I book 123 should be available in library

  Scenario: Give a not existing book back to library
    Given I am a Worker with id 333 and name "Lukasz"
     When I give a book with id 123 back to library
     Then I should not have booking
      And I book 123 should not be available in library