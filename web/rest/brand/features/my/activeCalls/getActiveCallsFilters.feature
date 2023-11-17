Feature: Retrieve active calls filters

  @createSchema
  Scenario: Retrieve brand active calls filter json
    Given I add Brand Authorization header
     When I add "Accept" header equal to "application/json"
      And I send a "GET" request to "/my/active_calls/realtime_filter?c=1&dp=1&cr=1&direction=inbound"
     Then the response status code should be 200
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/json"
      And the JSON should be equal to:
      """
      {
          "criteria": "trunks:b1:c1:cr1:dp1:*"
      }
      """
