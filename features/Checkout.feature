#For testing check out
@ignore
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
    When  I press button with attribute "onclick" and value is "billing.save()" and container is "checkout-step-billing"  
    When  I press button with attribute "onclick" and value is "shippingMethod.save()" and container is "checkout-step-shipping_method" 
    When  I press button with attribute "onclick" and value is "payment.save()" and container is "checkout-step-payment"
    When  I press button with attribute "onclick" and value is "review.save();" and container is "checkout-step-review"
    When I spin for a while to see a button with title "Continue Shopping"
    Then  I should see "Thank you for your purchase!"
    Then I should be on "/checkout/onepage/success/"
