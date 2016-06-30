Feature: No access to Page Management for Anonymous user
When I visit the website
As an Anonymous user
I should NOT be able to create, edit, and delete pages

  @api
  Scenario: An Anonymous user should NOT be able edit page
    Given I am not logged in
    Then I should NOT be able to edit a "page"

  @api
  Scenario: An Anonymous user should NOT be able to delete page
    Given I am not logged in
    Then I should NOT be able to delete a "page"

  @api
  Scenario: An Anonymous user should NOT be able create page
    Given I am not logged in
    Then I should NOT be able to create a "page"