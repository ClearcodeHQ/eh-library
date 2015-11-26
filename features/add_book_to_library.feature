Feature: Add book to library
  In order to allow workers to borrow a book
  As a leader
  I need to be able to add book to library

  @incomplete
  Scenario: Add book to library
    Given I am a Leader
     When I adds a book to the library
     Then the book should be available in the library