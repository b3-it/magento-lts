<?php
/**
 * Adminhtml grid item renderer concated
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Widget_Grid_Column_Renderer_Concated extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    /**
     * Renders grid column
     *
     * @param Varien_Object $row Zeileninstanz
     * 
     * @return string
     */
    public function render(Varien_Object $row) {
        $dataArr = array();
//         $index = $this->getColumn()->getIndex();
    	if ($data = $this->_getValue($row)) {
        	$dataArr = explode(',', $data);
	    	$data = '';
        	foreach ($dataArr as $line) {
	            $data .= "$line";
	        }
	        $data = $data!='' ? $data : '&nbsp;';
        }        
        
        $data = mb_ereg_replace("\<br\>", "<br/>", $data);
        // TODO run column type renderer
        return $data;
    }
    
    /**
     * Renders grid column
     *
     * @param Varien_Object $row Zeileninstanz
     *
     * @return string
     */
    public function renderExport(Varien_Object $row) {
    	$value = parent::renderExport($row);
    	
    	$value = mb_ereg_replace("&szlig;", "ß", $value);
    	$value = mb_ereg_replace("&ouml;", "ö", $value);
    	$value = mb_ereg_replace("&uuml;", "ü", $value);
    	$value = mb_ereg_replace("&auml;", "ä", $value);
    	$value = mb_ereg_replace("&Ouml;", "Ö", $value);
    	$value = mb_ereg_replace("&Uuml;", "Ü", $value);
    	$value = mb_ereg_replace("&Auml;", "Ä", $value);
    	
    	return trim(mb_ereg_replace("\<br[/]\>", ' ', $value));
    }

}