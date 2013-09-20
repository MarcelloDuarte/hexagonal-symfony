Feature: Manager can list his project sprints
  In order to track all my project sprints
  As a project manager
  I need to be able to see the list of sprints for a specific project

  Scenario: Getting two sprints for a project that has two
    Given I am a project manager
    And I have a "Nokia" project
    And I have scheduled 2 sprints for this project
    When I list this project sprints
    Then I should get a list of 2 sprints

  Scenario: Not getting any sprint if project doesn't have any
    Given I am a project manager
    And I have a "Nokia" project
    But I have not yet scheduled any sprints for this project
    When I list this project sprints
    Then I should get an empty list of sprints
