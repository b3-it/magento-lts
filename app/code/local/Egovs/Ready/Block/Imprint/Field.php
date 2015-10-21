<?php
/**
 *
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package         Egovs_Ready
 * @name            Egovs_Ready_Block_Imprint_Abstract
 * @author          Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright       Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license         http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class Egovs_Ready_Block_Imprint_Field extends Egovs_Ready_Block_Imprint_Abstract
{
    /**
     * Render imprint field
     *
     * @return string
     */
    protected function _toHtml() 
    {
        return $this->getData($this->getValue());
    }
}
