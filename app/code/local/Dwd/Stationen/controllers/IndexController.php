<?php
class Dwd_Stationen_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/stationen?id=15 
    	 *  or
    	 * http://site.com/stationen/id/15 	
    	 */
    	/* 
		$stationen_id = $this->getRequest()->getParam('id');

  		if($stationen_id != null && $stationen_id != '')	{
			$stationen = Mage::getModel('stationen/stationen')->load($stationen_id)->getData();
		} else {
			$stationen = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($stationen == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$stationenTable = $resource->getTableName('stationen');
			
			$select = $read->select()
			   ->from($stationenTable,array('stationen_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$stationen = $read->fetchRow($select);
		}
		Mage::register('stationen', $stationen);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    public function StationListAction()
    {
    	$res = "<items>
    	
    	   <item rdf:about=\"http://www.testshop.org/1\">
        <title>dynamische Station 1</title>
        <description><![CDATA[Hier ist HTML in der Beschreibung m&ouml;glich<br/><a href=\"javascript:void(0);\" onClick=\"klick(1);\">Klick mich :)</a>]]></description>
        <georss:point>54.693269420635 13.889560435438</georss:point>
        <dc:creator>dummy Name</dc:creator>
        <dc:date>2012-11-05T14:15:09</dc:date>
    </item>
    <item rdf:about=\"http://www.testshop.org/2\">
        <title>dynamische Station 2</title>
        <description><![CDATA[Hier ist HTML in der Beschreibung m&ouml;glich<br/><a href=\"javascript:void(0);\" onClick=\"klick(2);\">Klick mich :)</a>]]></description>
        <georss:point>52.171700190099 11.802585993826</georss:point>
        <dc:creator>dummy Name</dc:creator>
        <dc:date>2012-11-05T14:15:09</dc:date>
    </item>
    	</items>";
    	
    	$this->getResponse()->setBody($res);
    }
}