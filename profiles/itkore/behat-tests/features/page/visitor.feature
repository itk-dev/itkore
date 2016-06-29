Feature: Page Display
When I visit the site as an anonymous user i should be able to read and navigate pages

  @api
  Scenario: A visitor should only see promoted pages on the homepage
    Given "page" content:
      | title         | body         | status | promote |
      | Promoted Page | test content | 1      | 1       |
    When I go to the homepage
    Then I should see "Promoted Page"

  @api
  Scenario: A visitor should not see pages that are not promoted
    Given "page" content:
      | title     | body         | status | promote |
      | Test Page | test content | 1      | 0       |
    When I go to the homepage
    Then I should not see "Test Page"