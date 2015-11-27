@incomplete
Feature: Give a book back
  In order to give away book to another employee
  As an employee
  I want to give back a book

  Given there are books
      | id                                   | title                | authors    | isbn           |
      | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans | 0321125215     |
    And there are reservations
      | id                                   | book                                 | employee              |
      | c4e8ca4b-4528-41ec-8700-856c2f186b00 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | employee@clearcode.cc |

  Scenario: Give a book back
    Given book from reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00" was given away
     When I give back a book from reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00"
     Then there should be 0 reservations
