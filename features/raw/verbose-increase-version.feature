Feature: Developer runs actions to increase version number
  As a Developer
  I want to increase major, minor and patch numbers

  Scenario: Increasing major version
    Given the file "stamp.yml" contains:
      """
      actions:
        -
          name: parse_variable_from_file
          parameters:
            regex:    '/"version" *: *"(?P<version>[^"]+)"/'
            filename: 'metadata.json'
        -
          name: major_up
          parameters:
            variable: 'version'

      """
    And the file "metadata.json" contains:
      """
      {
        "name": "gajdaw-php_phars",
        "version": "50.1021.173",
        "author": "gajdaw"
      }
      """
    When I run command "raw:run" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["version"="50.1021.173"]
      major_up["version"="51.1021.173"]
      """

  Scenario: Increasing minor version
    Given the file "stamp.yml" contains:
      """
      actions:
        -
          name: parse_variable_from_file
          parameters:
            regex:    '/"ver" *: *"(?P<ver>[^"]+)"/'
            filename: 'metadata.json'
        -
          name: minor_up
          parameters:
            variable: 'ver'

      """
    And the file "metadata.json" contains:
      """
          "ver": "33.44.234",
      """
    When I run command "raw:run" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["ver"="33.44.234"]
      minor_up["ver"="33.45.234"]
      """

  Scenario: Increasing patch version
    Given the file "stamp.yml" contains:
      """
      actions:
        -
          name: parse_variable_from_file
          parameters:
            regex:    '/Version --- (?P<V>[\d\.]+)/'
            filename: 'metadata.json'
        -
          name: patch_up
          parameters:
            variable: 'V'

      """
    And the file "metadata.json" contains:
      """
          Version --- 533.344.11234
      """
    When I run command "raw:run" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["V"="533.344.11234"]
      patch_up["V"="533.344.11235"]
      """
