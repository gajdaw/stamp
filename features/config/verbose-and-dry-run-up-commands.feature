Feature: Developer runs commands with incorrect configuration
  As a Developer
  I want to be sure that nothing bad happens when there are
  problems with config files

  Scenario: Running patch:up without config
    When I run command "patch:up"
    Then I should see "Configuration file not found!"

  Scenario: Running patch:up with incorrect config
    Given the file "stamp.yml" contains:
      """
      a  b c: def
        fdsa
       -
      """
    When I run command "patch:up"
    Then I should see 'Unable to parse at line 2 (near "  fdsa").'
