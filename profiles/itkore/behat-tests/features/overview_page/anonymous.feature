Feature: No access to Overview page Management for Anonymous user
When I visit the website
As an Anonymous user
I should NOT be able to create, edit, and delete overview pages

  @api
  Scenario: An Anonymous user should NOT be able edit overview page
    Given I am not logged in
    Then I should NOT be able to edit a "overview_page"

  @api
  Scenario: An Anonymous user should NOT be able to delete overview page
    Given I am not logged in
    Then I should NOT be able to delete a "overview_page"

  @api
  Scenario: An Anonymous user should NOT be able create overview page
    Given I am not logged in
    Then I should NOT be able to create a "overview_page"