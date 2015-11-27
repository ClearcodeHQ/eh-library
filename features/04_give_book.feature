@incomplete
Feature: Give a book
  In order to have more qualified workers
  As a manager
  I need to be able to give book for worker to read

  Scenario: Give a booked book to Worker
    Given I am a Manager with id 123 and name "Gosia"
      And there is book with id 321 booked by Worker with id 333
     When I give book with id 321 to Worker with id 333
     Then worker with id 333 should have a book borrowed

  Scenario: Give a unbooked book to Worker
    Given I am a Manager with id 123 and name "Gosia"
      And there is book with id 321
     When I give book with id 321 to Worker with id 333
     Then worker with id 333 should not have a book borrowed

  Scenario: Give a borrowed book to Worker
    Given I am a Manager with id 123 and name "Gosia"
      And there is book with id 321 booked by Worker with id 333
     When I give book with id 321 to Worker with id 333
     Then worker with id 333 should not have a book borrowed

  Scenario: Give a not existing book to Worker
    Given I am a Manager with id 123 and name "Gosia"
     When I give book with id 321 to Worker with id 333
     Then worker with id 333 should have a book borrowed
