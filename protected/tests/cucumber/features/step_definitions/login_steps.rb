When /I am logged in as "(.*)" with password "(.*)"/ do |username, password|
  Then "I am on the login page"
  And "I fill in \"LoginForm[username]\" with \"#{username}\""
  And "I fill in \"LoginForm[password]\" with \"#{password}\""
  And "I press \"Login\""
  And "I should not see \"login\""
end
