Feature: User story features

  Background:
    Given I am authenticated as "edouard" with "test"

  Scenario: Start a user story
    As a developer
    I can start working on a user story
    and the user story is assigned to me

    When I start the story "2"
    Then the story should be in progress
    And should be assigned to edouard

  Scenario: Deliver a user story
    As a developer
    I deliver a user story when it is done
    The story should be assigned to the product owner

    Given I am working on the story "2"
    When I deliver the story "2"
    Then the story should be delivered
    And should be assigned to mini

  Scenario: Block a user story
    As a developer
    I block a user story when something is missing and blocks its' implementation

    Given I am working on the story "2"
    When I block the story "2"
    Then the story should be blocked

  Scenario: See list of todos
    As a developer
    I see the list of stories I am working on

    Given I am working on the story "1"
    And I am working on the story "2"
    When I go to the project "mini-scrum" homepage
    Then I should see 2 stories in the todo list