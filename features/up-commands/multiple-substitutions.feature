Feature: Developer runs multiple substitutions
  As a Developer
  I want to run patch:up, minor:up and major:up commands
  With multiple substitutions

  Scenario: Running patch:up with multiple substitutions in verbose mode
    Given the file "stamp.yml" contains:
      """
      filename:    'metadata.json'
      regex:       '/"version" *: *"(?P<version>[^"]+)"/'
      replacement: '"version": "{{ version }}"'
      replacements:
          -
              filename:    'a.txt'
              regex:       '/New version ([\d\.]+)/'
              replacement: 'New version {{ version }}'
          -
              filename:    'b.yml'
              regex:       '/version: ([\d\.]+)/'
              replacement: 'version: {{ version }}'
      """
    And the file "metadata.json" contains:
      """
      {
        "version": "6.248.112",
      }
      """
    And the file "a.txt" contains:
      """
      New version 6.248.112
      """
    And the file "b.yml" contains:
      """
      version: 6.248.112
      """
    When I run command "patch:up" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["version"="6.248.112"]
      patch_up["version"="6.248.113"]
      save_variable_to_file["version": "6.248.113"]
      save_variable_to_file[New version 6.248.113]
      save_variable_to_file[version: 6.248.113]
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
    And the file "a.txt" should contain:
      """
      New version 6.248.113
      """
    And the file "b.yml" should contain:
      """
      version: 6.248.113
      """

  Scenario: Running minor:up with multiple substitutions in verbose mode
    Given the file "stamp.yml" contains:
      """
      filename:    'metadata.json'
      regex:       '/"version" *: *"(?P<version>[^"]+)"/'
      replacement: '"version": "{{ version }}"'
      replacements:
          -
              filename:    'a.txt'
              regex:       '/New version ([\d\.]+)/'
              replacement: 'New version {{ version }}'
          -
              filename:    'b.yml'
              regex:       '/version: ([\d\.]+)/'
              replacement: 'version: {{ version }}'
      """
    And the file "metadata.json" contains:
      """
      {
        "version": "6.248.112",
      }
      """
    And the file "a.txt" contains:
      """
      New version 6.248.112
      """
    And the file "b.yml" contains:
      """
      version: 6.248.112
      """
    When I run command "minor:up" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["version"="6.248.112"]
      minor_up["version"="6.249.0"]
      save_variable_to_file["version": "6.249.0"]
      save_variable_to_file[New version 6.249.0]
      save_variable_to_file[version: 6.249.0]
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
    And the file "a.txt" should contain:
      """
      New version 6.249.0
      """
    And the file "b.yml" should contain:
      """
      version: 6.249.0
      """

  Scenario: Running major:up with multiple substitutions in verbose mode
    Given the file "stamp.yml" contains:
      """
      filename:    'metadata.json'
      regex:       '/"version" *: *"(?P<version>[^"]+)"/'
      replacement: '"version": "{{ version }}"'
      replacements:
          -
              filename:    'a.txt'
              regex:       '/New version ([\d\.]+)/'
              replacement: 'New version {{ version }}'
          -
              filename:    'b.yml'
              regex:       '/version: ([\d\.]+)/'
              replacement: 'version: {{ version }}'
      """
    And the file "metadata.json" contains:
      """
      {
        "version": "6.248.112",
      }
      """
    And the file "a.txt" contains:
      """
      New version 6.248.112
      """
    And the file "b.yml" contains:
      """
      version: 6.248.112
      """
    When I run command "major:up" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["version"="6.248.112"]
      major_up["version"="7.0.0"]
      save_variable_to_file["version": "7.0.0"]
      save_variable_to_file[New version 7.0.0]
      save_variable_to_file[version: 7.0.0]
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
    And the file "a.txt" should contain:
      """
      New version 7.0.0
      """
    And the file "b.yml" should contain:
      """
      version: 7.0.0
      """
