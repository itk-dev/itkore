Feature: No access to News Management for Anonymous user
When I visit the website
As an Anonymous user
I should NOT be able to create, edit, and delete newss

  @api
  Scenario: An Anonymous user should NOT be able edit news
    Given I am not logged in
    Then I should NOT be able to edit a "news"

  @api
  Scenario: An Anonymous user should NOT be able to delete news
    Given I am not logged in
    Then I should NOT be able to delete a "news"

  @api
  Scenario: An Anonymous user should NOT be able create news
    Given I am not logged in
    Then I should NOT be able to create a "news"