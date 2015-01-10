Feature: Developer runs patch:up command
  As a Developer
  I want to upgrade the patch version

  Scenario: Stamping a project without configuration
    Given I work in an empty project
     When I run patch:up
     Then I should see "Configuration file not found"

  Scenario: Stamping one file with a configuration file given
    Given the file ".stamper.yml" contains:
      """
      version_source:
          filename: 'metadata.json'
          regex:    '/^  "version": "([^"]+)",$/'
      replacements:
          -
              filename: 'metadata.json'
              regex:    '/^  "version": "([^"]+)",$'
      """
    And the file "metadata.json" contains:
      """
      {
        "name": "gajdaw-php_phars",
        "version": "50.1021.173",
        "author": "gajdaw"
      }
      """
    When I run patch:up
    Then the command should succeed in running actions:
    """
    ParseVersion[50.1021.173]
    PatchUp[50.1021.174]
    FilePregReplace[metadata.json,/^  "version": "([^"]+)",$/,/  "version": "50.1021.173",/]
    """
