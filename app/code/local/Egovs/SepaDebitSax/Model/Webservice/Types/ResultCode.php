<?php
/**
 * File for class SepaMvStructWSResultCode
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for SepaMvStructWSResultCode originally named WSResultCode
 * Documentation : Code: gibt den Returncode der entsprechenden Operation an; Description: textuelle Beschreibung zum Returncode
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_ResultCode extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The Code
     * Meta informations extracted from the WSDL
     * - nillable : false
     * @var integer
     */
    public $Code;
    /**
     * The Description
     * Meta informations extracted from the WSDL
     * - nillable : true
     * @var string
     */
    public $Description;
    /**
     * Constructor method for WSResultCode
     * @see parent::__construct()
     * @param integer $_code
     * @param string $_description
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_ResultCode
     */
    public function __construct($_code = NULL,$_description = NULL)
    {
        parent::__construct(array('Code'=>$_code,'Description'=>$_description),false);
    }
    /**
     * Get Code value
     * @return integer|null
     */
    public function getCode()
    {
        return $this->Code;
    }
    /**
     * Set Code value
     * @param integer $_code the Code
     * @return integer
     */
    public function setCode($_code)
    {
        return ($this->Code = $_code);
    }
    /**
     * Get Description value
     * @return string|null
     */
    public function getDescription()
    {
        return $this->Description;
    }
    /**
     * Set Description value
     * @param string $_description the Description
     * @return string
     */
    public function setDescription($_description)
    {
        return ($this->Description = $_description);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
