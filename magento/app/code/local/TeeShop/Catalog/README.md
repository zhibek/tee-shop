### Implementation of new Catalog Rules :
    
1. Listing colors separately regarding for their sizes
    ie. if you have 6 shirts 3 are Blue and the others are Red
        the user should only see 2 shirts only no matter what size 
        they are 

  ->  Implemented as following : 
        
        1. Overriding "prepareProductCollection()" in Mage_Catalog_Model_Layer
           in our Model TeeShop_Catalog_Model_layer
           
        2. using some helper functions like "prepareColourFilteredIds()"
        
   #### So.. How does it work ?
        
        A: First we get list of ids for one size of each color in the whole
           product collection , then we use it in the overridden function and
           filter the listing for those products only

    **Note:
        we did n't override "getProductCollection()" because it return a collection
        of products already filtered so we cant edit this collection by any means



2. Listing colors separately regarding for their sizes as ->((Search Result))<-


  ->  Implemented as following : 
        
        1. Overriding "getProductCollection()" in Mage_CatalogSearch_Model_Layer
           in our Model TeeShop_Search_Model_layer
           
        2. using some helper functions like "prepareColourFilteredIds()"
        
   #### So.. How does it work ?
        
        A: we filter fulltext collection (collection of search results)
           for only the products which match the search query which already 
           filtered before to apply this catalog rule



3. Forwarding simple products to their parent Configurable products

  ->  Implemented as following : 
        
        1. By observation of "controller_action_predispatch_catalog_product_view"
           event
           
        2. Overriding "initProduct()" method in Mage_Catalog_Helper_Product in 
           our Helper class TeeShop_Catalog_Helper_Catalog_Product

   #### So.. How does it work ?
        
        A: it chicks if the product has a parent then it change the url
           to its parent with values