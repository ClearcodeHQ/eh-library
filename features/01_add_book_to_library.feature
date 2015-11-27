Feature: Add book to library
  In order to allow employees to borrow a book
  As a manager
  I need to be able to add book to library

  Scenario: Add book to library
     When I add book
        | id                                   | title                | authors    | isbn       |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans | 0321125215 |
     Then I should have 1 book in library
