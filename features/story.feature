Feature: User story features

  Scenario: Visit the page to add a user story
    Given I am authenticated as "mini" with "test"
    When I go to "/mini-scrum/us/new"
    Then I should see "New story" in the "form" element

  Scenario: Add a user story
    As a product owner
    I add a user story to my project

    Given I am on "/mini-scrum/us/new"
    When I fill in the following:
      | title   | "As a product owner I add a story in the backlog" |
      | details | "I can add some details"                          |
      | points  | 3                                                 |
    And I press "Save"
    Then I should be redirected
    And I should see "As a product owner I add a story in the backlog" in the "p.lead" element
