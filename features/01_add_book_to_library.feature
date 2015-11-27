Feature: Add book to library
  In order to allow workers to borrow a book
  As a manager
  I need to be able to add book to library

  Scenario: Add book to library
    Given I am a Manager with id 123 and name "Gosia"
     When I add book with id 321 and title "The NeverEnding Story" to the library
     Then the book with id 321 should be available in the library

  Scenario: Add the same book to library twice
    Given I am a Manager with id 123 and name "Gosia"
      And library contains book with title "The NeverEnding Story"
     When I add book with id 321 and title "The NeverEnding Story" to the library
     Then the book with id 321 should not be available in the library