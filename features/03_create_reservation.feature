Feature: Reserving a book
  In order to take a book from the library
  As an employee
  I need to be able to reserve it

  Background:
    Given there are books
        | id                                   | title                | authors                                      | isbn           |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans                                   | 0321125215     |
        | 38483e7a-e815-4657-bc94-adc83047577e | REST in Practice     | Jim Webber, Savas Parastatidis, Ian Robinson | 978-0596805821 |

  Scenario: Reserving a book
     When I create reservation
        | id                                   | book                                 | email                 |
        | 7c10d831-e9b8-477b-9cf7-3e028565548b | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | employee@clearcode.cc |
     Then there should be 1 reservation
      And there should be 1 reservation for "a7f0a5b1-b65a-4f9b-905b-082e255f6038"

  Scenario: Reserving another book
    Given there is reservation for "38483e7a-e815-4657-bc94-adc83047577e" by "employee@clearcode.cc"
     When I create reservation
        | id                                   | book                                 | email                         |
        | 7c10d831-e9b8-477b-9cf7-3e028565548b | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | another.employee@clearcode.cc |
     Then there should be 2 reservations
      And there should be 1 reservation for "a7f0a5b1-b65a-4f9b-905b-082e255f6038"

  Scenario: Reserving book again
    Given there is reservation for "38483e7a-e815-4657-bc94-adc83047577e" by "employee@clearcode.cc"
     When I create reservation
        | id                                   | book                                 | email                         |
        | 7c10d831-e9b8-477b-9cf7-3e028565548b | 38483e7a-e815-4657-bc94-adc83047577e | another.employee@clearcode.cc |
     Then there should be 2 reservations
      And there should be 2 reservation for "38483e7a-e815-4657-bc94-adc83047577e"
