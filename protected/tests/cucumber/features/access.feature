Feature: Access

  Scenario: Can not acces the movies page
    Given I am on the movies page
    Then I should see "login"

  Scenario: Can not acces the users page
    Given I am on the users page
    Then I should see "login"

  Scenario: Can not acces the wishlist page
    Given I am on the wishlist page
    Then I should see "login"