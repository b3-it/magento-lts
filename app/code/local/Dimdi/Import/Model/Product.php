<?php

class Dimdi_Import_Model_Product extends Dimdi_Import_Model_Abstract
{
    private $_conn = null;
    
    public function run($conn)
    {
    	$this->_conn = $conn;
    	//try 
    	{
    		$this->_run();
    	}
    	//catch(Exception $ex)
    	{
    		//echo "Error: " . $ex->getMessage(); die();
    	}
    }
    
    
    
   
 
    
	private function _run()
    {
    	Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
    	$dir = Mage::getBaseDir('var').'/import';   
   
    	$hhParams = Mage::getModel('dimdiimport/hparameter');
    	
 		$i = 0;
		$res = $this->_conn->fetchAll("SELECT * FROM products WHERE products_status > 0");
		foreach($res as $row)
		{ 
			$i++;
			$item = Mage::getModel('catalog/product');
			$item->setData('groupscatalog_hide_group','-1');
			$item->setData('type_id','simple');
			$item->setData('osc_product_id',$row['products_id']);
			$attr = new Dimdi_Import_Model_Product_Attributes();
			$attr->load($this->_conn, $row['products_id'] );

			if($attr->isDownload())
			{
    			$item->setData('type_id','downloadable');
    			$item->setLinksPurchasedSeparately(false);
   			}
 		
    		$item->setData('attribute_set_id','4');
    		$item->setData('category_ids',$attr->getCategories());
			
			$item->setData('enable_googlecheckout','false');
			
			$item->setData('haushaltsstelle',$row['products_haushaltsstelle']);
			//$item->setData('kostenstelle',$row['products_kostenstelle']);
			//$item->setData('kostentraeger',$row['products_kostentraeger']);
			$item->setData('href','Webshop Archsax');
			$item->setData('href_mwst','Webshop Archsax');
			$item->setData('buchungstext','Webshop Archsax');
			$item->setData('buchungstext_mwst','Webshop Archsax');
			
			$item->setData('objektnummer',$row['products_objektnr']);
			
			$item->setData('objektnummer_mwst',$row['products_objektnr_mwst']);
			//$item->setData('objektnummer_mwst','Objektnummer Mwst');
			//$item->setData('ibewi_maszeinheit','VHS');
			
			$item->setData('visibility',Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
		
			$item->setData('price',$row['products_price']);
			//$item->setData('sku',$row['products_model']);	
			$item->setData('sku',$row['products_id']);
			$item->setData('status',Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
			$item->setData('msrp_enabled',2);
			$item->setData('msrp_display_actual_price_type',4);
			$item->setData('is_recurring',0);
			$item->setData('price_type',1);
			if(isset($this->_TAX_CLASS[$row['products_tax_class_id']]))
			{
				$item->setData('tax_class_id',$this->_TAX_CLASS[$row['products_tax_class_id']]);
			}
		
			$item->setData('url_path',$item->getUrlPath());
			$item->setData('weight',$row['products_weight']);
			$item->setMediaGallery(array('images'=>array(),'values'=>array()));
			
			
			$image = $row['products_image'];
			
			$item->setData('description',$attr->getDescription(2));
			$item->setData('short_description',$attr->getDescription(2));
			$item->setData('meta_description',$attr->getDescription(2));
			$item->setData('meta_title',$attr->getDescription(2));
			$item->setData('name',$attr->getName(2));			
			$item->setWebsiteIds(array('1'));
			
			$item->save();
/*
			$item->setStoreId(2);
			$item->setData('description',$attr->getDescription(1));
			$item->setData('short_description',$attr->getDescription(1));
			$item->setData('meta_description',$attr->getDescription(1));
			$item->setData('meta_title',$attr->getDescription(1));
			$item->setData('name',$attr->getName(1));			
			
			$item->save();
*/			
        	
        	//$website = Mage::getModel('catalog/product_website');
        	//$website->addProducts(array(1),array($item->getId()));//->save();
        	
        
        	
        	
			if($attr->isDownload())
			{
    			
    			$downloads = $attr->getDownloads();	
    			$download = $downloads[0];
    				    			
    			if(file_exists($dir."\\download\\".$download))
    			{
				  	$linkModel = Mage::getModel('downloadable/link')
	                       //->setData($linkItem)
	                       ->setLinkType( Mage_Downloadable_Helper_Download::LINK_TYPE_FILE)
	                       ->setProductId($item->getId())
	                       ->setStoreId($item->getStoreId())
	                       ->setWebsiteId($item->getStore()->getWebsiteId())
	                       ->setPrice(0)
	                       ->setNumberOfDownloads(0)
	                       ->setTitle('File')
	                       ;
	                       

        			$dest = Mage_Downloadable_Model_Link::getBasePath()."\\".$download;
        			$src = $dir."\\download\\".$download;       			
        			@copy($src, $dest);
       			
	                $linkModel->setLinkFile($download);
//	                echo "<pre>"; var_dump($linkModel); die();
	                $linkModel->save();
   			
    			}
   			}
   			
   			$stock = Mage::getModel('cataloginventory/stock_item');
			
			$stock->setData('stock_id',1);
			$stock->setData('product_id',$item->getId());
			$stock->setData('use_config_manage_stock',false);
        	$stock->save();
   			//return;
    		
        	
			if((strlen($image)>0) && (file_exists($dir."//".$image)))
			{
				$item = Mage::getModel('catalog/product')->load($item->getId());
				$item->addImageToMediaGallery($dir."//".$image,array('thumbnail','small_image','image'),false,false);
				$item->save();
			}
        	
    	}
    	
    	$conn = $item->getResource()->getReadConnection();
    	$conn->query('delete FROM catalog_product_flat_1');
    	//$conn->query('delete FROM catalog_product_flat_2');
    	// ;
    	echo $i . " Produkte importiert!";
    }
}
