Feature: Reserving a book
  In order to take a book from the library
  As a worker
  I need to be able to reserve it

  Background:
    Given I have books in library
      | id                                   | title                | authors                                      | isbn           |
      | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans                                   | 0321125215     |
      | 38483e7a-e815-4657-bc94-adc83047577e | REST in Practice     | Jim Webber, Savas Parastatidis, Ian Robinson | 978-0596805821 |
      | 979b4f4e-6c87-456a-a8b3-be6cff32b660 | Clean Code           | Robert C. Martin                             | 978-0132350884 |

  Scenario: Reserving a book
     When I reserve book "a7f0a5b1-b65a-4f9b-905b-082e255f6038" as "worker@clearcode.cc"
     Then there should be 1 reservation
      And there should be 1 reservation for "a7f0a5b1-b65a-4f9b-905b-082e255f6038"

  Scenario: Reserving another book
   Given there is reservation for "38483e7a-e815-4657-bc94-adc83047577e" by "worker@clearcode.cc"
    When I reserve book "a7f0a5b1-b65a-4f9b-905b-082e255f6038" as "another.worker@clearcode.cc"
    Then there should be 2 reservations
     And there should be 1 reservation for "a7f0a5b1-b65a-4f9b-905b-082e255f6038"

  Scenario: Reserving book again
    Given there is reservation for "38483e7a-e815-4657-bc94-adc83047577e" by "worker@clearcode.cc"
     When I reserve book "38483e7a-e815-4657-bc94-adc83047577e" as "another.worker@clearcode.cc"
     Then there should be 2 reservations
     And there should be 2 reservation for "38483e7a-e815-4657-bc94-adc83047577e"
