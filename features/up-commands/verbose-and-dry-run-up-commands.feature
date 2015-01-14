Feature: Developer runs commands to increase a version
  As a Developer
  I want to run patch:up, minor:up and major:up commands
  With minimal setup

  Scenario: Running patch:up with minimized setup in verbose mode
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

  Scenario: Running patch:up with minimized setup in verbose dry-run mode
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
    When I run command "patch:up" in verbose dry-run mode
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
        "version": "6.248.112",
      }
      """

  Scenario: Running minor:up with minimized setup in verbose mode
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
    When I run command "minor:up" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["version"="6.248.112"]
      minor_up["version"="6.249.0"]
      save_variable_to_file["version": "6.249.0"]
      command["git add metadata.json"]
      command["git commit -m "Version 6.249.0""]
      command["git tag -a v6.249.0 -m "Release 6.249.0""]
      """
    And the file "metadata.json" should contain:
      """
      {
        "version": "6.249.0",
      }
      """

  Scenario: Running minor:up with minimized setup in verbose dry-run mode
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
    When I run command "minor:up" in verbose dry-run mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["version"="6.248.112"]
      minor_up["version"="6.249.0"]
      save_variable_to_file["version": "6.249.0"]
      command["git add metadata.json"]
      command["git commit -m "Version 6.249.0""]
      command["git tag -a v6.249.0 -m "Release 6.249.0""]
      """
    And the file "metadata.json" should contain:
      """
      {
        "version": "6.248.112",
      }
      """

  Scenario: Running major:up with minimized setup in verbose mode
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
    When I run command "major:up" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["version"="6.248.112"]
      major_up["version"="7.0.0"]
      save_variable_to_file["version": "7.0.0"]
      command["git add metadata.json"]
      command["git commit -m "Version 7.0.0""]
      command["git tag -a v7.0.0 -m "Release 7.0.0""]
      """
    And the file "metadata.json" should contain:
      """
      {
        "version": "7.0.0",
      }
      """

  Scenario: Running major:up with minimized setup in verbose dry-run mode
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
    When I run command "major:up" in verbose dry-run mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["version"="6.248.112"]
      major_up["version"="7.0.0"]
      save_variable_to_file["version": "7.0.0"]
      command["git add metadata.json"]
      command["git commit -m "Version 7.0.0""]
      command["git tag -a v7.0.0 -m "Release 7.0.0""]
      """
    And the file "metadata.json" should contain:
      """
      {
        "version": "6.248.112",
      }
      """
