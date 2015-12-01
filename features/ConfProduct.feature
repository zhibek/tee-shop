#testing configurable product after adding color attribute

Feature: ConfProduct
  In order to test new variations in configurable product page
  @javascript 
  Scenario: Buying a blue-sky Xl LIVERPOOL CHILDREN'S PYJAMA
    Given I am on "catalogsearch/result/?q=base+liverpool"
    When I follow "Base Liverpool Children's Pyjama"
    Then I should see "In stock"
    #checking for brand and fabric care
    When I should see "Additional Information"
    Then the response should contain "Nike"
    Then the response should contain "No"
    #selecting white colour
    Then I select "blue" from "attribute134"
    #selecting off-white colour
    Then I select "Sky Blue" from "attribute92" 
    #select XL size
    Then I select "XL" from "attribute135" 
    When I press "Add to Cart"
    Then I should be on "/checkout/cart/"
    Then I should see "Base Liverpool Children's Pyjama was added to your shopping cart."