Feature: Movies

  Scenario: See the Movie Library
    Given I am logged in as "admin" with password "demo"
    When I click "Movies"
    Then I should not see "Your Movie-Library"

  Scenario: Logout
    Given I am logged in as "admin" with password "demo"
    Then I should see "login"