Feature: User Management for Anonymous user
When I visit the website
As an Anonymous user
I should NOT be able to create, edit, and delete users

  @api
  Scenario: An Anonymous user should NOT be able to edit users
    Given I am not logged in
    Then I should NOT be able to edit users

  @api
  Scenario: An Anonymous user should NOT be able to delete users
    Given I am not logged in
    Then I should NOT be able to delete users

  @api
  Scenario: An Anonymous user should NOT be able to create users
    Given I am not logged in
    Then I should NOT be able to create users