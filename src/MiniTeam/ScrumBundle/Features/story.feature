Feature: User story features

  Scenario: Add a user story
    As a product owner
    I add a user story to my project

    Given I am authenticated as "mini" with "test"
    When I go to "/mini-scrum/us/new"
    Then I should see "New story" in the "form" element
