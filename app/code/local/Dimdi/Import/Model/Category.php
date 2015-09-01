<?php

class Dimdi_Import_Model_Category extends Dimdi_Import_Model_Abstract
{
    private $_conn = null;
    
    public function run($conn)
    {
    	$this->_conn = $conn;
    	try 
    	{
    		$this->_importCategorys();
    		
    	}
    	catch(Exception $ex)
    	{
    		echo "Error: " . $ex->getMessage(); die();
    	}
    }
    
    
    
    private function _importCategorys()
    {
    	$res = $this->_conn->fetchAll("SELECT * FROM categories order by parent_id");
    	$i = 0;
		foreach($res as $cat)
		{
			$i++;
			//Store 0
			$meta = $this->_conn->fetchAll("SELECT * FROM categories_description WHERE categories_id =". $cat['categories_id']. " AND language_id=2" );
			$model = Mage::getModel('catalog/category');
			$model->setName($meta[0]['categories_name']);
			$model->setIsActive(1);
			$model->setData('display_mode','PRODUCTS');
        	$model->setData('is_anchor',0);
        	$model->setData('attribute_set_id',$model->getDefaultAttributeSetId());
			$model->setData('osc_category_id',$cat['categories_id']);
			$model->setData('url_key',$this->umlaute($meta[0]['categories_name']));
			if(intval($cat['parent_id']) != 0)
			{
				$parent = $this->_getCategoryByOscId($cat['parent_id']);
				if($parent)
				{
					$model->setPath($parent->getPath());
				}
			}
			else
			{
				$parent = Mage::getModel('catalog/category')->load(2);
				$model->setPath($parent->getPath());
			}
			$model->setStoreId(0);
			$model->save();
			
			//store 1
			$model->setStoreId(1);
			$model->save();
			
			
			//store 2
			/*
			$meta = $this->_conn->fetchAll("SELECT * FROM categories_description WHERE categories_id =". $cat['categories_id']. " AND language_id=1" );		
			$model->setName($meta[0]['categories_name']);
			$model->setStoreId(2);
			$model->save();
			*/

		}
		echo $i . " Kategorien importiert!";
    }
    
    private function _getCategoryByOscId($oscid)
    {
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	$attribute_id = $eav->getIdByCode('catalog_category', 'osc_category_id');
    	
    	$collection = Mage::getModel('catalog/category')->getCollection();
    	$collection->getSelect()->join(array('osc'=>'catalog_category_entity_varchar'),'e.entity_id = osc.entity_id',array('oscid'=>'value'))
    		->where("osc.value = $oscid")
    		->where("attribute_id = $attribute_id");
     	foreach($collection->getItems() as $item)
    	{
    		return $item;
    	}
    	return null;
    }
    
	
}
