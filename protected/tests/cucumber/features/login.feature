Feature: Login

  Scenario: View the login page
    Given I am on the home page
    Then I should see "login"

  Scenario: Failed Login wrong Password for Admin
    Given I am on the home page
    When I fill in "LoginForm[username]" with "admin"
    And I fill in "LoginForm[password]" with ""
    And I press "Login"
    Then I should see "Incorrect username or password."

  Scenario: Login with default admin password
    Given I am logged in as "admin" with password "demo"
#     Then I should see "logged in"
    Then I should not see "login"

  Scenario: Logout
    Given I am logged in as "admin" with password "demo"
    When I click "Logout (admin)"
    Then I should see "login"