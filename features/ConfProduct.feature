#For testing new variations in configurable product page 

Feature: ConfProduct
  In order to test new variations in configurable product page
  @javascript 
  Scenario: Buying a white Xl configurable t-shirt
    #Given I am on test products catalog page
    #When I follow "Base Config Product"
    Given I am on "/catalog/product/view/id/12/"
    Then I should see "Base Config Product"
    Then I should see "In stock"
    #checking for brand and fabric care
    When I should see "Additional Information"
    Then the response should contain "Nike"
    Then the response should contain "Machine Wash,COLD"
    #selecting white colour
    Then I select "white" from "attribute134"
    #select XL size
    Then I select "XL" from "attribute135" 
    When I press "Add to Cart"
    Then I should be on "/checkout/cart/"
    Then I should see "Base Config Product was added to your shopping cart."