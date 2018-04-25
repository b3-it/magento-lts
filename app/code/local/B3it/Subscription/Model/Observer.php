<?php

class B3it_Subscription_Model_Observer
{
	private $_ProductIdSaveBefore = 0;
	
	


    /**
     * Setting Bundle Items Data to product for father processing
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function onProductSaveAfter($observer)
    {
    	$dataObject = $observer->getEvent()->getDataObject();
    	$product = $observer->getEvent()->getProduct();

    	$this->_saveComponent($dataObject->getFormat(),$product);

    }
    

   
    
    private function findByNumber($nodes,$number)
    {
    	foreach ($nodes as $node){
    		if($node['number'] == $number){
    			return $node;
    		}
    	}
    
    	return null;
    }

    protected function _saveComponent($data, $product)
    {
        if (empty($data)) {
            $data = array();
        }
       
            
        foreach($data as $key => $item){
        	if($key == 'is_default'){
        		continue;
        	}
        	$model = Mage::getModel('b3it_subscription/periodeproduct');
        	if(isset($item['id']) && !empty($item['id'])){
        		$model->load($item['id']);
        		
        		if($item['deleted']  ){
        			$model->delete();
        			continue;
        		}
        	}
        	
        	
        	$model->setPos($item['position']);
        	$model->setEntityId($item['entity_id']);
        	$model->setProductId($product->getId());
        	$model->setStoreId($product->getStoreId());
        	$model->setIsDefault(0);
        	
        	
        	
        	$model->save();
        }
        
        $newItems = array();
    }
    
  
    
   

    
}
