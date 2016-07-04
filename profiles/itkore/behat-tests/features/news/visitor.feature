Feature: News Display
When I visit the site as an anonymous user i should be able to read and navigate Newss

  @api
  Scenario: A visitor should see a maximum of three (newest) news on the front page
    Given "news" content:
      | title | body      | field_excerpt | field_lead | promote | created          |
      | Test1 | Test body | Test Excerpt  | Test Lead  | 0       | 2013-09-11 12:30 |
      | Test2 | Test body | Test Excerpt  | Test Lead  | 0       | 2014-10-03 11:00 |
      | Test3 | Test body | Test Excerpt  | Test Lead  | 0       | 2014-11-21 11:00 |
      | Test4 | Test body | Test Excerpt  | Test Lead  | 0       | 2014-12-17 11:00 |
      | Test5 | Test body | Test Excerpt  | Test Lead  | 0       | 2015-01-14 11:00 |
    When I go to the homepage
    Then I should see "Nyheder"
    And I should not see "Test1"
    And I should not see "Test2"
    And I should see "Test3"
    And I should see "Test4"
    And I should see "Test5"

  @api
  Scenario: A visitor should see all news on /nyheder
    Given "news" content:
      | title | body      | field_excerpt | field_lead | promote | created          |
      | Test1 | Test body | Test Excerpt  | Test Lead  | 0       | 2013-09-11 12:30 |
      | Test2 | Test body | Test Excerpt  | Test Lead  | 0       | 2014-10-03 11:00 |
      | Test3 | Test body | Test Excerpt  | Test Lead  | 0       | 2014-11-21 11:00 |
      | Test4 | Test body | Test Excerpt  | Test Lead  | 0       | 2014-12-17 11:00 |
      | Test5 | Test body | Test Excerpt  | Test Lead  | 0       | 2015-01-14 11:00 |
    Then I visit "nyheder"
    And I should see "Test1"
    And I should see "Test2"
    And I should see "Test3"
    And I should see "Test4"
    And I should see "Test5"

  @api
  Scenario: A visitor should see News that are not promoted on the front page
    Given "news" content:
      | title          | body      | promote |
      | TestUnpromoted | Test body | 0       |
    When I go to the homepage
    Then I should see "TestUnpromoted"

  @api
  Scenario Outline: A visitor should see all relevant info when he views the News
    Given I am not logged in
    And I am viewing an "news" content:
      | title | <title> |
      | body  | <body>  |
    Then I should see "<title>"
    And I should see "<body>"

    Examples:
      | title        | body   |
      | Test Title 1 | Body 1 |
      | Test Title 2 | Body 2 |
      | Test Title 3 | Body 3 |
