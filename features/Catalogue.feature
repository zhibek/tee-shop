#For testing the existence of Tee-shirt on the catalogue

Feature: catalogue
  In order to check exitsance of link which redirect to test product category 
 
  Scenario: Opening magento's catalogue link
    Given I am on "/"
    When I fill in "search" with "test"
    And I press "Search"
    Then I should be on "/catalogsearch/result/?q=test"

# checking if the link redirect to the test-t-shirt page 
# comment this now till solving the links problem
#  Scenario: Opening test category page
#    Given I am on "/catalogsearch/result/?q=test"
#    When I follow "Test T-Shirt"
#    Then I should be on "/test-t-shirt.html"

