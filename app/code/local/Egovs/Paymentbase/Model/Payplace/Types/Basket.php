<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Basket
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Basket originally named basket
 * Documentation : Shopping basket, contains the articles the customer is buying and the shipping costs. For PayPal payments. The information will be displayed to the customer on the PayPal payment form. The sum of shipping costs and the prices of all articles has to be equal to the amount of the payment.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Basket extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The shippingCosts
     * Meta informations extracted from the WSDL
     * - documentation : Shipping costs in lower currency unit, e.g. cent.
     * - minOccurs : 0
     * @var float
     */
    public $shippingCosts;
    /**
     * The article
     * @var Egovs_Paymentbase_Model_Payplace_Types_Article
     */
    public $article;
    /**
     * Constructor method for basket
     * @see parent::__construct()
     * @param float $_shippingCosts
     * @param Egovs_Paymentbase_Model_Payplace_Types_Article $_article
     * @return Egovs_Paymentbase_Model_Payplace_Types_Basket
     */
    public function __construct($_shippingCosts = NULL,$_article = NULL)
    {
        parent::__construct(array('shippingCosts'=>$_shippingCosts,'article'=>$_article),false);
    }
    /**
     * Get shippingCosts value
     * @return float|null
     */
    public function getShippingCosts()
    {
        return $this->shippingCosts;
    }
    /**
     * Set shippingCosts value
     * @param float $_shippingCosts the shippingCosts
     * @return bool
     */
    public function setShippingCosts($_shippingCosts)
    {
        return ($this->shippingCosts = $_shippingCosts);
    }
    /**
     * Get article value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Article|null
     */
    public function getArticle()
    {
        return $this->article;
    }
    /**
     * Set article value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Article $_article the article
     * @return Egovs_Paymentbase_Model_Payplace_Types_Article
     */
    public function setArticle($_article)
    {
        return ($this->article = $_article);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Basket
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
