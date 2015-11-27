Feature: Add book to library
  In order to allow workers to borrow a book
  As a manager
  I need to be able to add book to library

#todo title should be unique

  Scenario: Add book to library as Manager
    Given I am a Manager with id 123 and name "Gosia"
      And I have book with id 321 and title "The NeverEnding Story"
     When I add book with id 321 to the library
     Then the book with id 321 should be available in the library

#this check probably needless
  Scenario: Add book to library as Worker
    Given I am a Worker with id 123 and name "Lukasz"
      And I have book with id 321 and title "The NeverEnding Story"
     When I add book with id 321 to the library
     Then the book with id 321 should not be available in the library

  Scenario: Add not existing book to library
    Given I am a Manager with id 123 and name "Gosia"
     When I add book with id 999 to the library
     Then the book with id 999 should not be available in the library