# features/homepage.feature
Feature: homepage
  In order to check magento's homepage

# checking if the title of the page is Homepage
  Scenario: Opening magento's homepage Title
    Given I am on "/"
    Then I should see "HOME PAGE" in the "h2" element



