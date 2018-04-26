<?php
class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Content extends Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Abstract
{
	protected $_component_model_type = "virtualgeo/components_content";
	
	public function getTitle()
	{
		return  $this->helper('virtualgeo')->__('Content');
	}
	
	
	
	public function getOptions($fields = null)
	{
		$options = parent::getOptions();
		$res = $this->_findChildren(null,$options);
		
		
		//var_dump($res); die;
		return $res;
	}
	
	protected function _findChildren($parentId, $options)
	{
		$res = array();
		foreach($options as $opt)
		{
			if($opt->getParentNodeId() == $parentId)
			{
				$opt->setChildren($this->_findChildren($opt->getId(),$options));
				$res[] = $opt;
			}
		}
		if(count($res) == null){
			return null;
		}
		return $res;
	}

	public function getNodeRenderer() {
        $nodeRenderer = $this->getData('node_renderer');
        if (!$nodeRenderer) {
            $nodeRenderer = array(
                'block' => 'virtualgeo/catalog_product_view_components_content_renderer_node',
                'template' => 'virtualgeo/catalog/product/view/components/content/renderer/node.phtml'
            );
        }

        return $this->getLayout()
            ->createBlock($nodeRenderer['block'])
            ->setTemplate($nodeRenderer['template'])
            ->setRenderedBlock($this);
    }
	
	public function getNodeHtml($node) {
		$nodeRenderer = $this->getNodeRenderer()->setNodeData($node);
		return $nodeRenderer->toHtml();

	}
}