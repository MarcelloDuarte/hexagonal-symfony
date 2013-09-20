Feature: Manager can list his projects
  In order to maintain and track my projects
  As a project manager
  I need to be able to see the list of all my projects

  Scenario: Getting two projects if there are two
    Given I am a project manager
    And I have 2 projects
    When I list my projects
    Then I should get a list of 2 projects

  Scenario: Not getting any project if there's none
    Given I am a project manager
    But I have no projects
    When I list my projects
    Then I should get an empty list of projects
