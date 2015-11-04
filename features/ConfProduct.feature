#For testing new variations in configurable product page 

@ignore
Feature: ConfProduct
  In order to test new variations in configurable product page
  @javascript 
  Scenario: Buying a white Xl configurable t-shirt
    Given I am on "/men/sport.html"
    When I follow "Base Config Product"
    Then I should see "Base Config Product"
    Then I should see "In stock"
    #checking for brand and fabric care
    When I should see "Additional Information"
    Then the response should contain "Adidas"
    Then the response should contain "Machine Wash,COLD"
    #selecting white colour
    Then I select "White" from "attribute134"
    #select XL size
    Then I select "XL" from "attribute135" 
    When I press "Add to Cart"
    Then I should be on "/checkout/cart/"
    Then I should see "Base Config Product was added to your shopping cart."