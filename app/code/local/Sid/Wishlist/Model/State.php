<?php
/**
 * Merkzettel - Prozess - State - Model
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_State extends Varien_Object
{
    const STEP_ADD_SELECT			= 'wishlist_select';
    const STEP_NEW_WISHLIST         = 'wishlist_new';
    const STEP_SUCCESS         		= 'wishlist_success';

    /**
     * Allow steps array
     *
     * @var array
     */
    protected $_steps;

    /**
     * Init model, steps
     *
     */
    public function __construct() {
        parent::__construct();
        
        $this->_steps = array(
            self::STEP_ADD_SELECT => new Varien_Object(array(
                'label' => Mage::helper('sidwishlist')->__('Select Wishlist')
            )),
        	self::STEP_NEW_WISHLIST => new Varien_Object(array(
                'label' => Mage::helper('sidwishlist')->__('Create New Wishlist')
            )),
            self::STEP_SUCCESS => new Varien_Object(array(
                'label' => Mage::helper('sidwishlist')->__('Wishlist Success')
            )),
        );

        foreach ($this->_steps as $step) {
            $step->setIsComplete(false);
        }

        $this->_steps[$this->getActiveStep()]->setIsActive(true);
    }

    /**
     * Liefert die verfügbaren Prozess-Steps
     *
     * @return array
     */
    public function getSteps()
    {
        return $this->_steps;
    }

    /**
     * Liefert Aktiven Step-Code
     *
     * @return string
     */
    public function getActiveStep() {
        $step = $this->getWishlistSession()->getProcessState();
        if (isset($this->_steps[$step])) {
            return $step;
        }
        return self::STEP_ADD_SELECT;
    }

    /**
     * Setzt den aktiven Step
     * 
     * @param string $step Step-Code
     * 
     * @return Sid_Wishlist_Model_State
     */
    public function setActiveStep($step) {
        if (isset($this->_steps[$step])) {
            $this->getWishlistSession()->setProcessState($step);
        } else {
            $this->getWishlistSession()->setProcessState(self::STEP_ADD_SELECT);
        }

        // Fix active step changing
        if (!$this->_steps[$step]->getIsActive()) {
            foreach ($this->getSteps() as $stepObject) {
                $stepObject->unsIsActive();
            }
            $this->_steps[$step]->setIsActive(true);            
        }
        $this->unsCompleteStep($step);
        
        return $this;
    }

    /**
     * Setzt Step als Completed
     *
     * @param string $step Step
     * 
     * @return Mage_Checkout_Model_Type_Multishipping_State
     */
    public function setCompleteStep($step)
    {
        if (isset($this->_steps[$step])) {
            $this->getWishlistSession()->setStepData($step, 'is_complete', true);
        }
        return $this;
    }

    /**
     * Liefert den Step Complete Sstatus
     *
     * @param string $step Step
     * 
     * @return bool
     */
    public function getCompleteStep($step)
    {
        if (isset($this->_steps[$step])) {
            return $this->getWishlistSession()->getStepData($step, 'is_complete');
        }
        return false;
    }

    /**
     * Complete Status von Step zurücksetzen
     *
     * @param string $step Step
     * 
     * @return Mage_Checkout_Model_Type_Multishipping_State
     */
    public function unsCompleteStep($step)
    {
        if (isset($this->_steps[$step])) {
            $this->getWishlistSession()->setStepData($step, 'is_complete', false);
        }
        return $this;
    }

    /**
     * Liefert Prozess - Session
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getWishlistSession()
    {
        return Mage::getSingleton('sidwishlist/session');
    }
}
