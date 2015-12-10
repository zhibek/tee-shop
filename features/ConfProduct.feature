#testing configurable product after adding color attribute

Feature: ConfProduct
  In order to test new variations in configurable product page
  @javascript 
  Scenario: Buying a Sky-blue Xl LIVERPOOL MEN'S CASUAL-BLUE
    Given I am on "catalogsearch/result/?q=liverpool"
    When I follow "Liverpool Men's Casual-blue"
    #forwarding simple product to its config
    Then I should see "Base Liverpool Men's Casual"
    Then I should see "In stock"
    #checking for brand and fabric care
    When I should see "Additional Information"
    Then the response should contain "Adidas"
    Then the response should contain "No"
    #selecting Sky-blue colour
    Then I select "Sky Blue" from "attribute92" 
    #select XL size
    Then I select "XL" from "attribute135" 
    When I press "Add to Cart"
    Then I should be on "/checkout/cart/"
    Then I should see "Base Liverpool Men's Casual was added to your shopping cart."