<?php
class Egovs_Base_Block_Page_Html extends Mage_Page_Block_Html
{
	/**
	 * Remove CSS class from page body tag
	 *
	 * @param string $className
	 * @return  Mage_Page_Block_Html
	 */
	public function removeBodyClass($className)
	{
		$className = preg_replace('#[^a-z0-9]+#', '-', strtolower($className));
		$existingClassNames = explode(' ', $this->getBodyClass());
		
		if ( empty($existingClassNames) OR empty($className) ) {
			return $this;
		}
		
		if ( $_index = array_search($className, $existingClassNames) ) {
			unset($existingClassNames[$_index]);
			$this->setBodyClass( implode(' ', $existingClassNames) );
		}
		
		return $this;
	}
}