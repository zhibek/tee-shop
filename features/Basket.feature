#For testing the existence of Liverpool Children's Casual in Basket

Feature: basket
  In order to check existence of Liverpool Children's Casual in basket
 
  Scenario: adding test-t-shirt to basket
    Given I am on "catalogsearch/result/?q=liverpool"
    Then I should see "Liverpool Children's Casual"
    When I follow "Liverpool Children's Casual"
    Then I should see "Liverpool Children's Casual"
    When I press "Add to Cart"
    Then the response should contain "Liverpool Children's Casual was added to your shopping cart."
    Then the response should contain "PROCEED TO CHECKOUT"