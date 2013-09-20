Feature: Manager can create a project
  In order to be able to track my project ceremonies
  As a project manager
  I need to be able to create a project

  Scenario: Successfully creating a project with a name
    Given I am a project manager
    When I create the "Nokia" project
    Then the "Nokia" project should be saved
    And I should be notified about the project creation success

  Scenario: Being unable to create a project without a name
    Given I am a project manager
    When I create the project
    Then the project should not be saved
    And I should be notified about the project creation failure
