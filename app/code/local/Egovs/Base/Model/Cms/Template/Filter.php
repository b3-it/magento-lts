<?php
/**
 * Created by PhpStorm.
 * User: Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * Date: 29.03.2019
 *
 */

/**
 * Class Egovs_Base_Model_Cms_Template_Filter
 *
 * @category  Egovs
 * @package   Egovs_Base
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2019 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Model_Cms_Template_Filter extends Mage_Cms_Model_Template_Filter
{
    /**
     * Filter the string as template.
     * Rewrited for logging exceptions
     *
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        $matches = [];
        if (preg_match_all('/{{.*}}/', $value, $matches) > 0 && isset($matches[0])) {
            foreach ($matches[0] as $match) {
                $decodedMatch = html_entity_decode($match);
                $decodedMatch = urldecode($decodedMatch);
                $value = mb_ereg_replace($match, $decodedMatch, $value);
            }
        }
        return parent::filter($value);
    }
}