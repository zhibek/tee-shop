#testing searching for brand

Feature: search brand
    
  Scenario: Searching Brand
    Given I am on the homepage
    When I fill in "search" with "nike"
    Then I press "Search"
    Then I should be on "/catalogsearch/result/?q=nike"
    
    # check for Nike Brand
    Then I should see "Nike"

    # check for Adidas Brand
    Then I should not see "Adidas"


