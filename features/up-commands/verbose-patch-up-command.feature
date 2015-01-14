Feature: Developer runs commands to increase a version
  As a Developer
  I want to run patch:up, minor:up and major:up commands
  With minimal setup

  Scenario: Running patch:up with minimized setup
    Given the file "stamp.yml" contains:
      """
      filename:    'metadata.json'
      regex:       '/"version" *: *"(?P<version>[^"]+)"/'
      variable:    'version'
      replacement: '"version": "{{ version }}"'
      """
    And the file "metadata.json" contains:
      """
      {
        "version": "6.248.112",
      }
      """
    When I run command "patch:up" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["version"="6.248.112"]
      patch_up["version"="6.248.113"]
      save_variable_to_file["version": "6.248.113"]
      command["git add metadata.json"]
      command["git commit -m "Version 6.248.113""]
      command["git tag -a v6.248.113 -m "Release 6.248.113""]
      """
    And the file "metadata.json" should contain:
      """
      {
        "version": "6.248.113",
      }
      """
