Feature: Create booking
  In order to take a book from the library
  As a worker
  I need to be able to create booking

  Scenario: Create booking
    Given I am a Worker with id 123 and name "Lukasz"
      And there is book with id 321 and title "The NeverEnding Story" in library
     When I create booking for book with id 321
     Then I should have booking

  Scenario: Booking not existing book
    Given I am a Worker with id 123 and name "Lukasz"
     When I create booking for book with id 321
     Then I should not have booking
