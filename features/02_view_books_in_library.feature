Feature: Views books in library
  In order to choose book to read
  As a worker
  I need to be able to view books in library

  Scenario: View books in library
    Given I am a Worker with id 123 and name "Lukasz"
      And there is book with id 321 and title "The NeverEnding Story" in library
     When I view books in library
     Then I should see 1 book

  Scenario: View books in empty library
    Given I am a Worker with id 123 and name "Lukasz"
      And there are no books in library
     When I view books in library
     Then I should not see any books
