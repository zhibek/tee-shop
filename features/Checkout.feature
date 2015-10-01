#For testing check out

Feature: check out
  Checking out
    
  @javascript  
  Scenario: Checking out test-t-shirt
    Given I mock add to cart
    When  I press "Proceed to Checkout"
    When  I check "login:guest"
    When  I press "onepage-guest-register-button"
    When  I fill in the following:
        | billing:firstname   | Cathleen          |
        | billing:lastname    | Collins           |
        | billing:email       | test@example.com  |
        | billing:street1     | Tempore exercit   |
        | billing:city        | Sit alias         |
        | billing:postcode    | 95823             |
        | billing:telephone   | 31845321546       |

    When  I select "DJ" from "billing:country_id"
    When  I check "billing:use_for_shipping_yes"
    When  I press button with attribute "onclick" and value is "billing.save()" 
    Given I wait for AJAX to finish
    When  I press button with attribute "onclick" and value is "shippingMethod.save()" 
    Given I wait for AJAX to finish
    When  I press button with attribute "onclick" and value is "payment.save()" 
    Given I wait for AJAX to finish
    When  I press "Place Order"
    Given I wait for AJAX to finish
    Then  I should see "Your order has been received"
    Then  I should see "Thank you for your purchase!"