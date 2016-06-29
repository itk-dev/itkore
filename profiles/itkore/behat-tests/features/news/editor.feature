Feature: News Management
When I log into the website
As an editor
I should be able to create, edit, and delete news

  @api
  Scenario: An Editor should be able edit news
    Given I am logged in as a user with the "Editor" role
    Then I should be able to edit an "news"

  @api
  Scenario: An Editor should be able to delete news
    Given I am logged in as a user with the "Editor" role
    Then I should be able to delete an "news"

  @api
  Scenario: An Editor should be able create news
    Given I am logged in as a user with the "Editor" role
    Then I should be able to create an "news"