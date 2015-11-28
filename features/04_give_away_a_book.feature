Feature: Give away a book
  In order to allow employee to take a book
  As a manager
  I want to give it away

  Background:
    Given there are books
        | id                                   | title                | authors    | isbn       |
        | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | Domain-Driven Design | Eric Evans | 0321125215 |
      And there are reservations
        | id                                   | book                                 | employee                      |
        | c4e8ca4b-4528-41ec-8700-856c2f186b00 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | employee@clearcode.cc         |
        | 75ad9b66-db69-404c-80a0-6acdfaf668d6 | a7f0a5b1-b65a-4f9b-905b-082e255f6038 | another.employee@clearcode.cc |

  Scenario: Give away a book
     When I give away book form reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00"
     Then book in reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00" should be given away

  Scenario: Give away book for second time
    Given book from reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00" was given away
     When I give away book form reservation "c4e8ca4b-4528-41ec-8700-856c2f186b00"
     Then I should be warned that book is already given away
