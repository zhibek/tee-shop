#For testing the existence of Tee-shirt in Basket
@ignore
Feature: basket
  In order to check existence of test-t-shirt in basket
 
  Scenario: adding test-t-shirt to basket
    Given I mock add to cart
    Then the "h2" element should contain "Test T-Shirt"
    Then the response should contain "Test T-Shirt was added to your shopping cart."
    Then the response should contain "PROCEED TO CHECKOUT"