Feature: Developer runs command to set dev version
  As a Developer
  To produce a latest build without the need to release
  Yet with embedding the unique version id
  I want to run version:dev command

  Scenario: Running version:dev in verbose mode
    Given I initialize a repo
    And the file "stamp.yml" contains:
      """
      filename:    'metadata.json'
      regex:       '/"version" *: *"(?P<version>[^"]+)"/'
      replacement: '"version": "{{ version }}"'
      """
    And I commit "First commit"
    And I tag "1.2.3" with message "foo bar"
    And the file "metadata.json" contains:
      """
      {
        "version": "6.248.112",
      }
      """
    And I commit "Second commit"
    When I run command "version:dev" in verbose mode
    Then I should see text matching '|save_variable_to_file\["version": "1.2.3-1|'
    Then the file "metadata.json" should match "/1\.2\.3-1-/"


