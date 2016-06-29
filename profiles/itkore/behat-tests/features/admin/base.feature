Feature: Test basic features
  Using the api driver

  @api
  Scenario: Run cron
    Given I am logged in as a user with the "Editor" role
    When I run cron
    And am on "admin/reports/dblog"
    Then I should see the link "Cron"

  @api
  Scenario: Create many nodes
    Given "page" content:
      | title    |
      | Page one |
      | Page two |
    And I am logged in as a user with the "Editor" role
    When I go to "admin/content"
    Then I should see "Page one"
    And I should see "Page two"

  @api
  Scenario: Create users
    Given users:
      | name     | mail            | status |
      | Joe User | joe@example.com | 1      |
    And I am logged in as a user with the "Editor" role
    When I visit "admin/people"
    Then I should see the link "Joe User"

  @api
  Scenario: Login as a user created during this scenario and log out
    Given users:
      | name      | status |
      | Test user |      1 |
    When I am logged in as "Test user"
    And I log out
    Then I should NOT be logged in

  @api
  Scenario: I should not be able to visit /admin when not logged in
    Given I am not logged in
    When I go to "admin"
    Then I should get a 403 HTTP response