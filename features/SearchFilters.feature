#testing search filters (category & primary colour & brand )

Feature: search filters
    
  
  Scenario: Checking out test-t-shirt
    Given I am on the homepage
    When I fill in "search" with "white"
    Then I press "Search"
    Then I should be on "/catalogsearch/result/?q=white"

    #head of table containing filter categories 
    Then I should see "Category" 
    
    #head of table containing filter prices 
    Then I should see "Price" 

    #head of table containing filter brands 
    Then I should see "Brand" 
    
    #head of table containing filter primary colours 
    Then I should see "Primary colour" 
    
    ###test filter redirect URLs

    # check for results of white with Nike Brand
    Then I check for "Nike" and "white"
    Then I should see "Brand: Nike"
    
    # check for results of white with Adidas Brand
    Then I check for "Adidas" and "white" 
    Then I should see "Brand: Adidas"
