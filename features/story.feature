Feature: User story features

  Scenario: Visit the page to add a user story
    Given I am authenticated as "mini" with "test"
    When I go to "/mini-scrum/us/new"
    Then I should see "New story" in the "form" element

  Scenario: Add a user story
    As a product owner
    I add a user story to my project

    Given I am authenticated as "mini" with "test"
    And I am on "/mini-scrum/us/new"
    When I fill in the following:
      | story_title   | "As a product owner I add a story in the backlog" |
      | story_details | "I can add some details"                          |
      | story_points  | 3                                                 |
    And I press "Save"
    Then I should see "As a product owner I add a story in the backlog" in the "p.lead" element

  Scenario: Start a user story
    As a developer
    I can start working on a user story
    and the user story is assigned to me

    Given I am authenticated as "edouard" with "test"
    And I am on "/mini-scrum/us/2"
    When I start the user story
    Then I should see "doing" in the "#status" element
    And I should see "edouard" in the "#assignee" element

  Scenario: Deliver a user story
    As a developer
    I deliver a user story when it is done
    The story should be assigned to the product owner

    Given I am authenticated as "edouard" with "test"
    And I am working on the story "2"
    And I am on "/mini-scrum/us/2"
    When I deliver the user story
    Then I should see "to_validate" in the "#status" element
    And I should see "mini" in the "#assignee" element