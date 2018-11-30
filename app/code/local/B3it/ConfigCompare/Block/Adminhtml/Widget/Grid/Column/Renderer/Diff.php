<?php
class  B3it_ConfigCompare_Block_Adminhtml_Widget_Grid_Column_Renderer_Diff extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders grid column
     *
     * @param Varien_Object $row
     * @return string
     */
    public function _getValue(Varien_Object $row)
    {
        $format = ( $this->getColumn()->getFormat() ) ? $this->getColumn()->getFormat() : null;
        $defaultValue = $this->getColumn()->getDefault();
        $data = parent::_getValue($row);
        $string = is_null($data) ? $defaultValue : $data;
        
       
        if(strlen($string) > 300){
	        $id = rand(1,10000);
	        $btn  = '<button id="btn_p_'.$id.'" type = "button" onclick="$(\''.$id.'\').removeClassName(\'col_diff_small\'); $(\'btn_p_'.$id.'\').hide(); $(\'btn_m_'.$id.'\').show();">+</button>';
	        $btn2 = '<button id="btn_m_'.$id.'" type = "button" onclick="$(\''.$id.'\').addClassName(\'col_diff_small\'); $(\'btn_m_'.$id.'\').hide(); $(\'btn_p_'.$id.'\').show();" style="display:none;">-</button>';
	        $string = $btn.$btn2.'<div id="'.$id.'" class="col_diff_small">'. $string .'</div>';
        }
        return html_entity_decode($string,ENT_QUOTES,'UTF-8');
    }
}
