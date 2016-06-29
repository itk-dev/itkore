Feature: User Management for Editor
When I log into the website
As an Editor
I should NOT be able to create, edit, and delete users

  @api
  Scenario: An Editor should NOT be able to edit users
    Given I am logged in as a user with the "Editor" role
    Then I should be able to edit users

  @api
  Scenario: An Editor should NOT be able to delete users
    Given I am logged in as a user with the "Editor" role
    Then I should be able to delete users

  @api
  Scenario: An Editor should NOT be able to create users
    Given I am logged in as a user with the "Editor" role
    Then I should be able to create users