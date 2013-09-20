Feature: Sprint ceremonies are autoscheduled
  In order to always have a picture of ideal schedule first
  As a project manager
  I want my sprint ceremonies to be autoscheduled according to a specification

  Scenario: Autoscheduling a 10 day sprint
    Given I am a project manager
    And I have a "Nokia" project
    And the ceremony specification for a 10 day sprint is:
      | ceremony             | day of sprint | hours |
      | sprint planning      | 1             | 2     |
      | example workshop     | 5             | 2     |
      | sprint review        | 10            | 2     |
      | sprint retrospective | 10            | 1     |
    When I schedule a 10 day sprint for this project starting today
    Then the new sprint should be scheduled starting today
    And this sprint ceremonies schedule should follow the specification

  Scenario: Autoscheduling a 15 day sprint
    Given I am a project manager
    And I have a "Nokia" project
    And the ceremony specification for a 15 day sprint is:
      | ceremony             | day of sprint | hours |
      | sprint planning      | 1             | 3     |
      | example workshop     | 10            | 3     |
      | sprint review        | 15            | 3     |
      | sprint retrospective | 15            | 2     |
    When I schedule a 15 day sprint for this project starting tomorrow
    Then the new sprint should be scheduled starting tomorrow
    And this sprint ceremonies schedule should follow the specification

  Scenario: Being unable to schedule a sprint with length that has no specification
    Given I am a project manager
    And I have a "Nokia" project
    But there is no specification for a 16 day sprint
    When I schedule a 16 day sprint for this project starting tomorrow
    Then the sprint should not be scheduled
    And I should be notified about the sprint scheduling failure
