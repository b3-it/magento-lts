# Index Concept
## Indexer
 - Model/Index/Product.php
 - Model/Index/Cms.php
## Observer
 - solr_search_product_save
   - File: Product.php
   - Function: onProductSaveAfter
   - Event: catalog_product_save_after
 - solr_search_product_delete
   - File: Product.php
   - Function: onProductDeleteBefore
   - Event: catalog_product_delete_before
 - solr_search_cms_save
   - File: Cms.php
   - Function: onPageSaveAfter
   - Event: cms_page_save_after
 - solr_search_cms_delete
   - File: Cms.php
   - Function: onPageDeleteBefore
   - Event: cms_page_delete_before
## Description
### Product
Only Products of type 'Mage_Catalog_Model_Product' with a Id will be indexed.  
They also need to be visible in search and activated.  

A Product will automatically be indexed after it got saved (observer).  
All products can be indexed with the backend option System/Solr Search/Index.  

If a product is not visible or activated the connected document (solr) will be removed and the product not indexed. (same result as deleting the product)  
With the 'index all option', all product documents (solr) will be removed, before indexing them again.  

NOTE: the 'index all option' will only remove documents (solr) of the same store, if the core contains multiple stores, they will consist.  

NOTE: if a product gets saved manually, it will effect all stores, because changes to a website product can effect the product in other websites.

Only searchable and some solr specific attributes are indexed.  
This specific attributes are:
 - type : 'product'
 - id : combination of $type_$productId_storeId
 - db_id : the real database id of the product
 - store_id : the id of the specific store (prevents some wrong configuration bugs)
 - name : single string for suggester (title of product)

'Frontend Select' attributes will indexed the label of the saved option.  
'Frontend Bool' attributes will indexed true/false instead of 0/1.  
The 'Price' attribute will be selected based on special price, and tax.  
If tax is included in the frontend, it will be indexed with tax.  
If a special price applies to the product, the special price will be indexed, otherwise the normal price.  

(BCP only)  
If the product is of type 'configurable', the indexed price will be the price of the cheapest child.  

Field types of attributes:
 - frontend_input 'select', 'boolean' and 'text' are indexed as '_string'  
 (else)
 - backend_type 'decimal' is indexed as '_decimal'
 - backend_type 'date' is indexed as '_date'
 - frontend_input 'textarea' and 'multiSelect' are indexed as '_text'
### Cms Page
Needs to be activated with the backend configuration 'search_cms'  

Only specific attributes are indexed.  
This specific attributes are:
 - type : 'page'
 - id : combination of $type_$pageId_storeId
 - db_id : the real database id of the page
 - store_id : the id of the specific store (prevents some wrong configuration bugs)
 - name : single string for suggester (title of page)
 - content_text : content of the page for fulltext search
 - title_string : title of the page for copy fields
## Backend Configurations
 - solr_general / index_options
   - search_cms  
   Activate or deactivate indexing of cms pages
   - solr_product_type  
   Select product_types which should not be indexed
## Magento Functions / Models
 - Mage_Catalog_Model_Product_Visibility
   - getVisibleInSearchIds()  
   This function will return the constants for 'visible in search'.  
   (VISIBILITY_IN_SEARCH = 3)  
   (VISIBILITY_BOTH = 4)
 - Mage_Catalog_Model_Resource_Product_Attribute_Collection
   - addSearchableAttributeFilter()  
   Selects only attributes which are searchable
 - Mage_Catalog_Model_Product_Status  
   (STATUS_ENABLED = 1)  
   (STATUS_DISABLED = 2)
