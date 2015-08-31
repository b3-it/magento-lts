<?php 
class Stala_CustomerReports_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Fügt eine SelectBox für Kundengruppen hinzu und ersetzt den Storeswitcher durch
	 * einen modifizierten Switcher der mit dem Kundengruppenswitcher zusammen arbeitet.
	 * 
	 * @param Mage_Adminhtml_Block_Report_Grid $grid
	 * @return Mage_Adminhtml_Block_Report_Grid oder null
	 */
	public function prepareLayout($grid) {
		if (is_null($grid))
			return null;
		
		if (!($grid instanceof Mage_Adminhtml_Block_Report_Grid))
			return null;
			
		$grid->setChild('group_switcher',
            $grid->getLayout()->createBlock('stalareports/customer_group_switcher')
                ->setUseConfirm(false)
                ->setSwitchUrl($grid->getUrl('*/*/*', array('store'=>null)))
        );
        
        //Original store switcher entfernen
        //Sonst kann man nur CustomerGroup oder Store auswählen
        $grid->unsetChild('store_switcher');
        $grid->setChild('store_switcher',
            $grid->getLayout()->createBlock('stalareports/store_switcher')
                ->setUseConfirm(false)
                ->setSwitchUrl($grid->getUrl('*/*/*', array('store'=>null)))
                ->setTemplate('report/store/switcher.phtml')
        );
                
        //cgroup kann auch 0 sein --> gibt sonst Probleme
        $cgroup = $grid->getRequest()->getParam('cgroup');
    	if (isset($cgroup)) {
    		Mage::register('cgroup', $cgroup, true);
    	} else {
    		Mage::unregister('cgroup');
    	}
    	
		$store = $grid->getRequest()->getParam('store');
    	$website = $grid->getRequest()->getParam('website');
    	$group = $grid->getRequest()->getParam('group');
    	
    	if (isset($store)) {
            Mage::register('store', $store, true);
            Mage::unregister('website');
            Mage::unregister('group');
        } else if (isset($website)){
            Mage::register('website', $website, true);
            Mage::unregister('store');
            Mage::unregister('group');
        } else if (isset($group)){
            Mage::register('group', $group, true);
            Mage::unregister('website');
            Mage::unregister('store');
        } else {
        	Mage::unregister('store');
        	Mage::unregister('website');
            Mage::unregister('group');
        }
		
		return $grid;
	}	
	
	
	
	
    public function getGroupCollectionToOptionArray($showGuests = true)
    {
    	/* @var $collection Mage_Customer_Model_Entity_Group_Collection */
        $collection = Mage::getResourceModel('customer/group_collection');
        
        
        //Bei einigen Reports machen Gäste keinen Sinn -> filtern!
        if (isset($collection) && (!$showGuests)) {
        		$collection->addFieldToFilter('customer_group_id',array('gt'=> 0));
        	}
        	
		$res  = array();
		$res[0] = Mage::helper('stalareports')->__('All Customer Groups');
		foreach ($collection->getItems() as $item)
		{
			$res[$item->getId()+1] = $item->getCode();
		}
        	
       
        	
        return $res;
    }
	
	
	
	
}