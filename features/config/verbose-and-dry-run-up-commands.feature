Feature: Developer runs commands with incorrect configuration
  As a Developer
  I want to be sure that nothing bad happens when there are
  problems with config files

  Scenario: Running patch:up without config in verbose mode
    When I run command "patch:up" in verbose mode
    Then I should see "Configuration file not found!"
