Feature: Developer runs patch:up command
  As a Developer
  I want to upgrade the patch version

#  Scenario: Stamping a project without configuration
#    Given I use fake command runner
#     When I run patch:up with dry-run option
#     Then I should see "Configuration file not found"

  Scenario: Stamping one file with a configuration file given
    Given the file ".stamper.yml" contains:
      """
      preActions: ~
      postActions: ~
      actions:
        -
          name: parseVariables
          parameters:
            name:     version
            regex:    '/^  "version": "([^"]+)",$/'
            filename: 'metadata.json'
        -
          name: patchUp
          parameters:
            variable: version
        -
          name: pregReplace
          parameters:
            filename: 'metadata.json'
            src:    '/^  "version": "([^"]+)",$'
            dest:    '  "version": "{{ version }}"'
      """
    And the file "metadata.json" contains:
      """
      {
        "name": "gajdaw-php_phars",
        "version": "50.1021.173",
        "author": "gajdaw"
      }
      """
    When I run command patch:up with option --dry-run
    Then the command should succeed in running actions:
    Then I should see "Hello, world!"
    """
    - parseVariables
    - patchUp
    - pregReplace
    """
