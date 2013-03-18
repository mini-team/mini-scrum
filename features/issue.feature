Feature: Issue features

  Background:
    Given I am authenticated as "mini" with "test"

  Scenario: Add issue to a user story
    As a product-owner
    I can add an issue on a user story that needs to be validated
    and the issue is visible on the user story page

    Given I am viewing story 4
    When I report an issue "This is a new issue"
    And I submit my issue
    Then I should see "This is a new issue"