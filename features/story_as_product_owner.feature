Feature: User story features

  Background:
    Given I am authenticated as "mini" with "test"

  Scenario: Visit the page to add a user story
    When I go to "/mini-scrum/us/new"
    Then I should see "Add story" in the "form" element

  Scenario: Add a user story
    As a product owner I add a user story to my project.

    Given I am on "/mini-scrum/us/new"
    When I fill in the following:
      | story_title   | "As a product owner I add a story in the backlog" |
      | story_details | "I can add some details"                          |
      | story_points  | 3                                                 |
    And I press "Save"
    Then I should see "As a product owner I add a story in the backlog" in the "p.lead" element

  Scenario: Plan a user story
    As a product owner I plan a user story
    for the new sprint.

    Given I am on "/mini-scrum/us/1"
    When I follow "Add to sprint"
    Then I should see "sprint-backlog" in the "#status" element