<?php
require_once 'abstract.php';

/**
 * Shell Script to test tax rules
 *
 * @category    B3it
 * @package     B3it_Shell
 * @author      Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2018 B3 IT Systeme GmbH <https://www.b3-it.de>
 */
class B3it_Shell_Tax extends Mage_Shell_Abstract
{
    /**
     * Run script
     *
     */
    public function run() {
        if ($this->getArg('test')) {
            $customerId = $this->getArg('customer');
            if (!is_numeric($customerId) || $customerId < 1) {
                $customerId = 1;
            }
            $customer = Mage::getModel('customer/customer')->load($customerId);
            if ($this->getArg('vatValidationError')) {
                $newGroupId = (int)Mage::getStoreConfig(Mage_Customer_Helper_Data::XML_PATH_CUSTOMER_VIV_ERROR_GROUP, $customer->getStore());
                //echo "New group ID: $newGroupId";
                $customer->setGroupId($newGroupId);
            }
            if (!$customer->getId()) {
                echo sprintf("Customer with ID: %s not found!\n", $customerId);
                die(1);
            }
            $productId = $this->getArg('product');
            $fields = array('tax_class_id');
            if (!is_numeric($productId) || $productId < 1) {
                $productId = 1;
            }
            $product = Mage::getModel('catalog/product')->load($productId, $fields);
            if (!$product->getId()) {
                echo sprintf("Product with ID: %s not found!\n", $productId);
                die(1);
            }

            $productTaxClassId = $product->getTaxClassId();
            $request = Mage::getSingleton('germantax/tax_calculation')
                ->setCustomer($customer)
                ->getRateRequest();
            $request->setProductClassId($productTaxClassId);
            $request->setIsVirtual($product->getIsVirtual());

            $customerTaxClass = Mage::getModel('tax/class')->load($customer->getTaxClassId());
            $productTaxClass = Mage::getModel('tax/class')->load($product->getTaxClassId());
            echo sprintf(
                "Customer ID: %s with tax class: '%s'\nCustomer group ID: %s\n",
                $customer->getId(),
                $customerTaxClass->getClassName(),
                $customer->getGroupId()
            );
            if ($customer->getGroupId() != $customer->getOrigData('group_id')) {
                echo sprintf(
                    "Customer group ID is temporarily changed from %s to: %s\n",
                    $customer->getOrigData('group_id'),
                    $customer->getGroupId()
                );
            }
            echo sprintf(
                "Product ID: %s with tax class: '%s'\n",
                $product->getId(),
                $productTaxClass->getClassName()
            );

            $vatValid = $this->getArg('validVAT');
            if ($vatValid !== false && is_numeric($vatValid) && ($vatValid == 0 || $vatValid == 1)) {
                echo sprintf("Custom Taxvat requested! Original taxvat was: %s\n", $request->getTaxvat());
                $request->setTaxvat($vatValid == 1 ? 1 : 0);
            }

            $resource = Mage::getSingleton('germantax/tax_calculation')->getResource();
            $result = $resource->getCalculationProcess($request);

            echo sprintf("Taxvat is: %s\n", $request->getTaxvat());
            echo sprintf("Request:\n%s\n", var_export($request->getData(), true));
            if (empty($result)) {
                echo sprintf("NO RESULT!:\n%s\n", var_export($result, true));
            } else {
                echo sprintf("Result:\n%s\n", var_export($result, true));
            }
            return;
        }

        echo $this->usageHelp();
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f tax.php -- [options]
        php -f tax.php -- test --customer 1 --product 1

  test                         Test tax calculation
  --customer <customer_id>     Customer ID to test
  --product  <product_id>      Product ID to test
  --validVAT <1 or 0>          Set VAT to be valid or invalid
  --vatValidationError         Simulate VAT validation error => Forcing change of customer group
  help                         This help

USAGE;
    }
}

$shell = new B3it_Shell_Test();
$shell->run();