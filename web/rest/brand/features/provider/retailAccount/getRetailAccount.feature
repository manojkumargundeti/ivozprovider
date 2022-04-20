Feature: Retrieve retail accounts
  In order to manage retail accounts
  As a brand admin
  I need to be able to retrieve them through the API.

  @createSchema
  Scenario: Retrieve the retail accounts json list
    Given I add Brand Authorization header
     When I add "Accept" header equal to "application/json"
      And I send a "GET" request to "retail_accounts"
     Then the response status code should be 200
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/json; charset=utf-8"
      And the JSON should be equal to:
    """
      [
          {
              "name": "testRetailAccount",
              "description": "",
              "directConnectivity": "no",
              "id": 1,
              "company": 3,
              "domainName": "retail.irontec.com",
              "status": [
                  {
                      "contact": "sip:yealinktest@10.10.1.109:5060",
                      "publicContact": false,
                      "received": "sip:212.64.172.26:5060",
                      "publicReceived": true,
                      "expires": "2031-01-01 00:59:59",
                      "userAgent": "Yealink SIP-T23G 44.80.0.130"
                  }
              ]
          }
      ]
    """

  Scenario: Retrieve certain retail account json
    Given I add Brand Authorization header
     When I add "Accept" header equal to "application/json"
      And I send a "GET" request to "retail_accounts/1"
     Then the response status code should be 200
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/json; charset=utf-8"
      And the JSON should be like:
    """
      {
          "name": "testRetailAccount",
          "description": "",
          "transport": "udp",
          "ip": null,
          "port": null,
          "password": "9rv6G3TVc-",
          "fromDomain": null,
          "directConnectivity": "no",
          "ddiIn": "yes",
          "t38Passthrough": "no",
          "id": 1,
          "company": "~",
          "transformationRuleSet": null,
          "outgoingDdi": null
      }
    """
