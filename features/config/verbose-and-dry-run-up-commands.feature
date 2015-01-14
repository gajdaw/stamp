Feature: Developer runs commands with incorrect configuration
  As a Developer
  I want to be sure that nothing bad happens when there are
  problems with config files

  Scenario: Running patch:up without config
    When I run command "patch:up"
    Then I should see "Configuration file not found!"

  Scenario: Running patch:up with incorrect config file that doesnt parse
    Given the file "stamp.yml" contains:
      """
      a  b c: def
        fdsa
       -
      """
    When I run command "patch:up"
    Then I should see 'Unable to parse at line 2 (near "  fdsa").'

  Scenario: Running patch:up with config without mandatory filename
    Given the file "stamp.yml" contains:
      """
      regex:       one
      replacement: two
      """
    When I run command "patch:up"
    Then I should see 'Cannot find "filename" entry in config file!'

  Scenario: Running patch:up with config without mandatory regex
    Given the file "stamp.yml" contains:
      """
      filename:    three
      replacement: two
      """
    When I run command "patch:up"
    Then I should see 'Cannot find "regex" entry in config file!'

  Scenario: Running patch:up with config without mandatory replacement
    Given the file "stamp.yml" contains:
      """
      filename: three
      regex:    two
      """
    When I run command "patch:up"
    Then I should see 'Cannot find "replacement" entry in config file!'

  Scenario: Running patch:up when file defined in filename doesnt exist
    Given the file "stamp.yml" contains:
      """
      filename:    one
      regex:       two
      replacement: three
      """
    When I run command "patch:up"
    Then I should see 'The file "one" does not exist!'
