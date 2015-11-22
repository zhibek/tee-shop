#For testing Pagination Frame  & number of products in the page

Feature: Pagination
  In order to how many page blocks(Pagination Frame) to move between 
  setting was 3 pages ( current , 2 , 3 ) for this test
 
  Scenario: Test Pagination Frame
    Given I am on homepage
    When I fill in "search" with "liverpool"
    When I press "Search"
    Then I should be on "/catalogsearch/result/?q=liverpool"
    Then the response should contain "<li class=\"current\">1</li>"
    #button to move to the second page
    Then the response should contain "/catalogsearch/result/index/?p=2&amp;q=liverpool\">2"
    #button to move to the 3rd page
    Then the response should contain "/catalogsearch/result/index/?p=3&amp;q=liverpool\">3"

  Scenario: Test products/page drop downlist
    Given I am on homepage
    When I fill in "search" with "liverpool"
    When I press "Search"
    Then I should be on "/catalogsearch/result/?q=shirt"
    #this means that the page shows 20 products
    Then the response should contain "1-20"
