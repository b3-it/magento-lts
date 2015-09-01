<?php

class Dimdi_Import_Model_Hparameter extends Dimdi_Import_Model_Abstract
{
    private $_conn = null;
    private $_hhparameters = null;
    
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
 		$i = 0;
 		$hhstellen = array();
		$res = $this->_conn->fetchAll("SELECT Distinct products_haushaltsstelle as value FROM products WHERE products_status > 0");
		foreach($res as $row)
		{ 
			$i++;
			$item = Mage::getModel('paymentbase/haushaltsparameter');
			$item->setData('title','Haushaltsstelle ('.$row['value'].')');
			$item->setData('value',$row['value']);
			$item->setData('type',Egovs_Paymentbase_Model_Haushaltsparameter_Type::HAUSHALTSTELLE);
			$item->setCreatedTime(now())->setUpdateTime(now());
			$item->save();
			
			$hhstellen[$row['value']] = $item->getId();
			
		}
		
		$res = $this->_conn->fetchAll("SELECT Distinct products_objektnr as value, products_haushaltsstelle FROM products WHERE products_status > 0");
		foreach($res as $row)
		{
			$i++;
			$item = Mage::getModel('paymentbase/haushaltsparameter');
			$item->setData('title','Objektnummer ('.$row['value'].')');
			$item->setData('value',$row['value']);
			$item->setData('type',Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER);
			$item->setCreatedTime(now())->setUpdateTime(now());
			$item->save();
			
			if(isset($hhstellen[$row['products_haushaltsstelle']])){
				$parent = $hhstellen[$row['products_haushaltsstelle']];
				$item->saveHHStellen(array($parent));
			}	
		}
		
		$res = $this->_conn->fetchAll("SELECT Distinct products_objektnr_mwst as value, products_haushaltsstelle  FROM products WHERE products_status > 0");
		foreach($res as $row)
		{
			$i++;
			$item = Mage::getModel('paymentbase/haushaltsparameter');
			$item->setData('title','Objektnummer Mwst ('.$row['value'].')');
			$item->setData('value',$row['value']);
			$item->setData('type',Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER_MWST);
			$item->setCreatedTime(now())->setUpdateTime(now());
			$item->save();
			
			if(isset($hhstellen[$row['products_haushaltsstelle']])){
				$parent = $hhstellen[$row['products_haushaltsstelle']];
				$item->saveHHStellen(array($parent));
			}
				
		}
		
		
    	echo $i . " Haushaltstellen importiert!";
    }
}
