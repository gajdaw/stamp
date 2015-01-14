Feature: Developer runs actions that result in shell commands
  As a Developer
  I want to run the action that runs various shell commands
  Using variables from the container

  Scenario: Echo the version
    Given the file "stamp.yml" contains:
      """
      actions:
        -
          name: parse_variable_from_file
          parameters:
            regex:    '/\[(?P<title>[^\]]+)\]/'
            filename: 'metadata.json'
        -
          name: command
          parameters:
            commandTemplate: 'echo "{{ title }}"'

      """
    And the file "metadata.json" contains:
      """
          [Lorem ipsum]
      """
    When I run command "raw:run" in verbose mode
    Then the output should contain:
      """
      parse_variable_from_file["filename"="metadata.json"]["title"="Lorem ipsum"]
      command["echo "Lorem ipsum""]
      """
