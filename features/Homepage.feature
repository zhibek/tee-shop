# features/homepage.feature
Feature: homepage
  In order to check magento's homepage
 
  Scenario: Opening magento's homepage link
    Given I am on "/"
    Then I should be on "http://tee-shop.local/"

# checking if the title of the page is Homepage
  Scenario: Opening magento's homepage Title
    Given I am on "/"
    Then I should see "HOME PAGE" in the "h2" element



