Feature: Developer runs patch:up command in dry-run mode
  As a Developer
  I want to list what actions would have been executed
  for various configuration files.

  Scenario: Parsing variables
    Given the file "stamp.yml" contains:
      """
      actions:
        -
          name: parseVariable
          calls:
            -
              regex:    '/^  "version": "(?P<version>[^"]+)",$/'
              filename: 'metadata.json'
            -
              name:     authorString
              regex:    '/^  "(?P<AUTHOR>[^"]+)": "gajdaw",$/'
              filename: 'metadata.json'
      """
    And the file "metadata.json" contains:
      """
      {
        "name": "gajdaw-php_phars",
        "version": "50.1021.173",
        "author": "gajdaw"
      }
      """
    When I run command "patch:up" in verbose dry mode
    Then the output should contain:
    """
    - parseVariable
    - variables[version="50.1021.173",AUTHOR="author"]
    """
