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

    When I plan the story "1"
    Then the story should be planned

  Scenario: Unplan a user story
    As a product owner I unplan a user story.

    Given the story "1" is planned
    When I unplan the story "1"
    Then the story should be in backlog

  Scenario: Delete a user story
    As a product owner I can delete a user story

    Given the story "1" is in the backlog
    When I delete the story "1"
    Then I should be on "/mini-scrum/us-list/product-backlog"
    And I should not see text matching "ETQ user ceci est une user story fixture"

  Scenario: Refuse a user story
    As a product owner I can refuse a user story

    Given the story "1" was delivered by edouard
    When I refuse the story "1"
    Then the story should be in progress
    And it should be assigned to edouard

  Scenario: Accept a user story
    As a product owner I can accept a user story

    Given the story "1" is delivered
    When I accept the story "1"
    Then the story should be done

  Scenario Outline: Deblock a user story
    As a product owner I can deblock a user story

    Given the story "1" is <initial>
    Then the story "1" is blocked
    When I deblock the story "1"
    Then the story should be planned

  Examples:
    | initial     |
    | planned     |
    | in progress |

  Scenario: See list of delivered stories
    As a product owner
    I see the list of stories I have to validate

    Given the story "3" was delivered by edouard
    And the story "4" was delivered by edouard
    When I go to the project "mini-scrum" homepage
    Then I should see 2 stories in the validation list