Feature: Login

  Scenario: Successfull authentication
    If the user succeed to post the authentication form
    he should be authenticated
    and redirected to the project page
    
    Given I am on "/login"
    And I fill in "username" with "mini"
    And I fill in "password" with "test"
    When I press "Login"
    Then I should be authenticated
    And I should be on "Mini Scrum" project

  Scenario: Failed authentication
    If the user failed to login he is asked to refill
    the authentication form

    Given I am on "/login"
    And I fill in "username" with "foo"
    And I fill in "password" with "bar"
    When I press "Login"
    Then I should be on "/login"