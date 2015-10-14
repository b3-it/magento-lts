<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   	Egovs
 * @package    	Egovs_Video
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

/**
 * Diese Klasse erweitert Magento um die Möglichkeit FLV Videos zu importieren.
 *
 * Der Dateifilter wird um *.flv erweitert.
 *
 * @category   	Egovs
 * @package    	Egovs_Video
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @see Mage_Adminhtml_Block_Catalog_Product_Helper_Form_Gallery_Content
 */
class Egovs_Video_Block_Adminhtml_Catalog_Product_Helper_Form_Gallery_Content extends Mage_Adminhtml_Block_Catalog_Product_Helper_Form_Gallery_Content
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('egovs/catalog/product/helper/gallery.phtml');
	}

	/**
	 * Der Dateifilter wird um *.flv erweitert
	 *
	 * @return Egovs_Video_Block_Adminhtml_Catalog_Product_Helper_Form_Gallery_Content
	 *
	 */
	protected function _prepareLayout() {
        parent::_prepareLayout();

        $filters = $this->getUploader()->getConfig()->getFilters();
        $filters['media'] = array(
                	'label' => Mage::helper('adminhtml')->__('Media (.avi, .flv)'),
                	'files' => array('*.avi', '*.flv')
        );
        $filters['html5'] = array(
                	'label' => Mage::helper('adminhtml')->__('HTML5 (.ogg, .mp4, .webm, .wav, .ogv, .oga, .m4v, .m4a)'),
                	'files' => array('*.ogg', '*.mp4', '*.webm', '*.wav', '*.ogv', '*.oga', '*.m4v', '*.m4a')
        );

        $this->getUploader()->getConfig()->setFilters($filters);

        return $this;
    }
}