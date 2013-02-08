Feature: User story features

  Background:
    Given I am authenticated as "edouard" with "test"

  Scenario: Start a user story
    As a developer
    I can start working on a user story
    and the user story is assigned to me

    When I start the user story "2"
    Then it should be in progress
    And should be assigned to edouard

  Scenario: Deliver a user story
    As a developer
    I deliver a user story when it is done
    The story should be assigned to the product owner

    Given I am working on the story "2"
    And I am on "/mini-scrum/us/2"
    When I deliver the user story
    Then I should see "to-validate" in the "#status" element
    And I should see "mini" in the "#assignee" element