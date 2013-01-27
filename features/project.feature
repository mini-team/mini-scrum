Feature: Project

  Scenario: Project page
    Given I am authenticated as "mini" with "test"
    When I go to "/mini-scrum"
    Then I should see "Members" in the "div#members" element
    And should see 3 "div#members ul li" elements