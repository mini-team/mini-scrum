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

    When I plan the user story "1"
    Then the story should be planned

  Scenario: Unplan a user story
    As a product owner I unplan a user story.

    Given the story "1" is planned
    When I unplan the user story "1"
    Then the story should be in backlog

  Scenario: Delete a user story
    As a product owner I can delete a user story

    Given the story "1" is in the backlog
    When I delete the user story "1"
    Then I should be on "/mini-scrum/us-list/product-backlog"
    And I should not see text matching "ETQ user ceci est une user story fixture"

  Scenario: Refuse a user story
    As a product owner I can refuse a user story

    Given the story "1" is delivered
    When I refuse the user story "1"
    Then the story should be in progress

  Scenario: Accept a user story
    As a product owner I can accept a user story

    Given the story "1" is delivered
    When I accept the user story "1"
    Then the story should be done
