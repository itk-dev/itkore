Feature: Overview page Management
When I log into the website
As an editor
I should be able to create, edit, and delete overview page

  @api
  Scenario: An Editor should be able edit overview page
    Given I am logged in as a user with the "Editor" role
    Then I should be able to edit an "overview_page"

  @api
  Scenario: An Editor should be able to delete overview page
    Given I am logged in as a user with the "Editor" role
    Then I should be able to delete an "overview_page"

  @api
  Scenario: An Editor should be able create overview page
    Given I am logged in as a user with the "Editor" role
    Then I should be able to create an "overview_page"