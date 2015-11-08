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

    # href value that redirect to white and Test Products category filter
    Then the response should contain "catalogsearch/result/index/?cat=3&amp;q=white" 
    
    # href value that redirect to white and Women category filter
    Then the response should contain "catalogsearch/result/index/?cat=7&amp;q=white" 
    
    # href value that redirect to white and children category filter
    Then the response should contain "catalogsearch/result/index/?cat=11&amp;q=white" 
        
    # href value that redirect to white and Nike filter
    Then the response should contain "catalogsearch/result/index/?brand=3&amp;q=white" 
    
    # href value that redirect to white and Adidas filter
    Then the response should contain "catalogsearch/result/index/?brand=4&amp;q=white" 
    
    # href value that redirect to white search filter
    Then the response should contain "catalogsearch/result/index/?primary_colour=8&amp;q=white" 
    
    # href value that redirect to black search filter
    Then the response should contain "catalogsearch/result/index/?primary_colour=9&amp;q=white" 
    
    
