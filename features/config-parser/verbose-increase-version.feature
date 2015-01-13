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
          name: increase_major_version
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
    When I run command "major:up" in verbose mode
    Then the output should contain:
    """
    parse_variable_from_file["filename"="metadata.json"]["version"="50.1021.173"]
    increase_major_version["version"="51.1021.173"]
    """
