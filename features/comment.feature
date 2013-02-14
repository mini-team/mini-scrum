Feature: Comment features

  Background:
    Given I am authenticated as "edouard" with "test"

  Scenario: Add comment to a user story
    As a developer
    I can add a comment on a user story
    and the comment is visible on the user story page

    Given I am viewing story 2
    When I write comment "This is a new comment"
    And I submit my comment
    Then I should see "This is a new comment"