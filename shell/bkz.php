<?php
require_once 'abstract.php';

/**
 * Shell Script to get Kassenzeichen info
 *
 * @category    B3it
 * @package     B3it_Shell
 * @author      Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright   Copyright (c) 2018 B3 IT Systeme GmbH <https://www.b3-it.de>
 */
class B3it_Shell_Bkz extends Mage_Shell_Abstract
{
    /**
     * Run script
     *
     */
    public function run() {
        if ($this->getArg('info')) {
            $bkz = $this->getArg('bkz');
            if (!is_numeric($bkz) || $bkz < 1) {
                echo sprintf("No valid Kassenzeichen %s!\n", $bkz);
                die(1);
            }

            $result= Mage::helper('paymentbase')->lesenKassenzeichenInfo($bkz);

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
Usage:  php -f bkz.php -- [options]
        php -f bkz.php -- info --bkz 1

  info                         Info about Kassenzeichen
  --bkz <BKZ>                  Kassenzeichen
  help                         This help

USAGE;
    }
}

$shell = new B3it_Shell_Bkz();
$shell->run();
