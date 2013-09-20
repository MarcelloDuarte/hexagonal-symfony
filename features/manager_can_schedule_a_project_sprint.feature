Feature: Manager can schedule a project sprint
  In order to be able to track my project sprints
  As a project manager
  I need to be able to schedule a sprint inside specific project

  Scenario: Successfully scheduling a 10 day sprint
    Given I am a project manager
    And I have a "Nokia" project
    When I schedule a 10 day sprint for this project starting today
    Then the new sprint should be scheduled starting today
    And I should be notified about the sprint scheduling success

  Scenario: Successfully scheduling a 15 day sprint
    Given I am a project manager
    And I have a "Nokia" project
    When I schedule a 15 day sprint for this project starting tomorrow
    Then the new sprint should be scheduled starting tomorrow
    And I should be notified about the sprint scheduling success

  Scenario: Being unable to schedule a 0 day sprint
    Given I am a project manager
    And I have a "Nokia" project
    When I schedule a 0 day sprint for this project starting today
    Then the sprint should not be scheduled
    And I should be notified about the sprint scheduling failure
