<?php
class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Content extends Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Abstract
{
	protected $_component_model_type = "virtualgeo/components_content";
	
	public function getTitle()
	{
		return  $this->helper('virtualgeo')->__('Content');
	}
	
	
	
	public function getOptions()
	{
		$options = parent::getOptions();
		$res = $this->_findCildren(null,$options);
		
		
		//var_dump($res); die;
		return $res;
	}
	
	protected function _findCildren($parentId,$options)
	{
		$res = array();
		foreach($options as $opt)
		{
			if($opt->getParentNodeId() == $parentId)
			{
				$opt->setChildren($this->_findCildren($opt->getId(),$options));
				$res[] = $opt;
			}
		}
		if(count($res) == null){
			return null;
		}
		return $res;
	}
	
	
	public function getTreeHtml()
	{
		$options = $this->getOptions();
		$res = array();
		foreach($options as $option)
		{
			$res[] = $this->_getNodeHtml($option);
		}
		
		return implode(' ', $res);
	}
	
	
	
	
	protected function _getNodeHtml($node)
	{
		$res = array();
		$res[] = '<li>';
		
		$res[] = '<div>';
		$res[] = '<input type="checkbox"';
		$res[] = 'class="checkbox"';
		if($node->getIsChecked())
		{
			$res[] = 'checked="checked"';
		}
		if($node->getReadonly())
		{
			$res[] = 'disabled="disabled"';
		}
		$res[] = 'name="'.$this->getHtmlID().'[]"';
		$res[] = 'value="'.$node->getEntityId().'"';
		$res[] = 'data-id="'.$this->getHtmlID().'"';
		$res[] = 'data-code="'.$node->getCode().'"';
		$res[] = 'data-shortname="'.$node->getShortname().'"';
		$res[] = 'data-name="'.$node->getName().'"/>';
		$res[] = $node->getName().'</div>';
		
		if($node->getChildren())
		{
			$res[] = '<ul style="margin-left:20px;">';
			foreach($node->getChildren() as $child)
			{
				$res[] = $this-> _getNodeHtml($child);
			}
			$res[] = '</ul>';
		}
		
		$res[] = '</li>';
		
		return implode(' ', $res);
	}
	
}