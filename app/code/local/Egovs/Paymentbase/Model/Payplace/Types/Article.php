<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Article
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Article originally named article
 * Documentation : Article in a shopping basket. For PayPal payments. The information will be displayed to the customer on the PayPal payment form.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Article extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $name;
    /**
     * The code
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $code;
    /**
     * The quantity
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $quantity;
    /**
     * The price
     * Meta informations extracted from the WSDL
     * - documentation : Price in lower currency unit, e.g. cent.
     * - minOccurs : 0
     * @var int
     */
    public $price;
    /**
     * The description
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $description;
    /**
     * Constructor method for article
     * @see parent::__construct()
     * @param string $_name
     * @param string $_code
     * @param int $_quantity
     * @param float $_price
     * @param string $_description
     * @return Egovs_Paymentbase_Model_Payplace_Types_Article
     */
    public function __construct($_name = NULL,$_code = NULL,$_quantity = NULL,$_price = NULL,$_description = NULL)
    {
        parent::__construct(array('name'=>$_name,'code'=>$_code,'quantity'=>$_quantity,'price'=>$_price,'description'=>$_description),false);
    }
    /**
     * Get name value
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name value
     * @param string $_name the name
     * @return string
     */
    public function setName($_name)
    {
        return ($this->name = $_name);
    }
    /**
     * Get code value
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Set code value
     * @param string $_code the code
     * @return string
     */
    public function setCode($_code)
    {
        return ($this->code = $_code);
    }
    /**
     * Get quantity value
     * @return int|null
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    /**
     * Set quantity value
     * @param int $_quantity the quantity
     * @return bool
     */
    public function setQuantity($_quantity)
    {
        return ($this->quantity = $_quantity);
    }
    /**
     * Get price value
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Set price value
     * @param float $_price the price
     * @return bool
     */
    public function setPrice($_price)
    {
        return ($this->price = $_price);
    }
    /**
     * Get description value
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Set description value
     * @param string $_description the description
     * @return string
     */
    public function setDescription($_description)
    {
        return ($this->description = $_description);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Article
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
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
