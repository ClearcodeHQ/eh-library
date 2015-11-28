Feature: Views reservations in library
  In order to know how long I will be waiting for book
  As a employee
  I need to be able to view list of reservations

  Background:
    Given there are books
        | id                                   | title                | authors    | isbn       |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans | 0321125215 |
      And there are reservations
        | id                                   | book                                 | employee                      |
        | c4e8ca4b-4528-41ec-8700-856c2f186b00 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | employee@clearcode.cc         |
        | 75ad9b66-db69-404c-80a0-6acdfaf668d6 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | another.employee@clearcode.cc |

  Scenario: View books in library
     When I list reservations for book "a7f0a5b1-b65a-4f9b-905b-082e255f6038"
     Then I should see 2 reservations
