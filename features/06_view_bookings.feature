@incomplete
Feature: Views bookings in library
  In order to know how long I will be waiting for book
  As a worker
  I need to be able to view list of bookings

  Scenario: View books in library
    Given I am a Worker with id 123 and name "Lukasz"
      And there is a book with id 333 booked
     When I view bookings in library
     Then I should see 1 bookings

  Scenario: View books in empty library
    Given I am a Worker with id 123 and name "Lukasz"
      And there are no bookings in library
     When I view bookings in library
     Then I should not see any bookings
