Feature: Views books in library
  In order to choose book to read
  As an employee
  I need to be able to view books in library

  Background:
    Given I have books in library
        | id                                   | title                | authors                                      | isbn           |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans                                   | 0321125215     |
        | 38483e7a-e815-4657-bc94-adc83047577e | REST in Practice     | Jim Webber, Savas Parastatidis, Ian Robinson | 978-0596805821 |
        | 979b4f4e-6c87-456a-a8b3-be6cff32b660 | Clean Code           | Robert C. Martin                             | 978-0132350884 |

  Scenario: List books in library
     When I list books
     Then I should see 3 books

  Scenario: List books paginated
     When I list 2 page of books paginated by 2 books on page
     Then I should see 1 book
