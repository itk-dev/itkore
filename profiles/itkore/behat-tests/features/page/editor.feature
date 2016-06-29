Feature: Page Management
When I log into the website
As an editor
I should be able to create, edit, and delete page

  @api
  Scenario: An Editor should be able edit page
    Given I am logged in as a user with the "Editor" role
    Then I should be able to edit an "page"

  @api
  Scenario: An Editor should be able to delete page
    Given I am logged in as a user with the "Editor" role
    Then I should be able to delete an "page"

  @api
  Scenario: An Editor should be able create page
    Given I am logged in as a user with the "Editor" role
    Then I should be able to create an "page"